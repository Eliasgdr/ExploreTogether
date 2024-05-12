<?php
include 'databaseConnection.php';

session_start(); // Start session to use $_SESSION variable

if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

if (!isset($_GET['query'])) {
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
    error_log('Database error: ' . $e->getMessage());
}
?>