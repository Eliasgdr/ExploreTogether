<?php
include 'databaseConnection.php';

session_start(); // Start session to use $_SESSION variable

header('Content-Type: application/json');

$response = array(); // Initialize an empty array for the response

if (!isset($_SESSION['userID'])) {
    // Redirect to login page if not logged in
    http_response_code(401);
    echo json_encode(array('success' => false, 'status_text' => "User not logged in", 'status_code' => 401));
    exit;
}

if (!isset($_GET['query'])) {
    // Exit if the query parameter is not provided
    http_response_code(400);
    echo json_encode(array('success' => false, 'status_text' => "Query parameter is required.", 'status_code' => 400));
    exit;
}

try {
    // Get the search query from the request parameters
    $searchQuery = $_GET['query'];
    $userID = (int)$_SESSION['userID'];

    // Create a new PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare the SQL statement to search for users
    $stmt = $conn->prepare("SELECT ID, username FROM users WHERE username LIKE :query AND ID != :userID AND ID NOT IN (SELECT blockedUserID FROM blockedusers WHERE userID = :userID) AND ID NOT IN (SELECT userID FROM blockedusers WHERE blockedUserID = :userID)");
    $stmt->bindValue(':query', "%$searchQuery%", PDO::PARAM_STR);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT); // Bind with $userID directly
    $stmt->execute();

    // Fetch the search results
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the search results in JSON format
    echo json_encode($users);
} catch(PDOException $e) {
    // Handle database connection errors
    http_response_code(500);
    echo json_encode(array('success' => false, 'status_text' => "Error: " . $e->getMessage(), 'status_code' => 500));
}
?>