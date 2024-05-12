<?php
include 'databaseConnection.php';

session_start(); // Start session to use $_SESSION variable

header('Content-Type: application/json');

$response = array(); // Initialize an empty array for the response

if (!isset($_SESSION['userID'])) {
    // Redirect to login page if not logged in
    $response = array('success' => false, 'message' => "User not logged in");
    echo json_encode($response);
    exit;
}

if (!isset($_GET['query'])) {
    // Exit if the query parameter is not provided
    $response = array('success' => false, 'message' => "Query parameter is required.");
    echo json_encode($response);
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
    $stmt = $conn->prepare("SELECT ID, username FROM users WHERE username LIKE :query AND ID != :userID");
    $stmt->bindValue(':query', "%$searchQuery%", PDO::PARAM_STR);
    $stmt->bindValue(':userID', $userID, PDO::PARAM_INT); // Bind with $userID directly
    $stmt->execute();

    // Fetch the search results
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output the search results in JSON format
    echo json_encode($users);
} catch(PDOException $e) {
    // Handle database connection errors
    $response = array('success' => false, 'message' => "Database error: " . $e->getMessage());
    echo json_encode($response);
}
?>