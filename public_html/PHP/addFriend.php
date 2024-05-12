<?php
// Database connection parameters
include 'databaseConnection.php';

// Start the session
session_start();

$response = array();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Redirect to login page if not logged in
    $response = array('success' => false, 'message' => "User not logged in");
    echo json_encode($response);
    exit;
}

// Check if friend ID is provided in the request and is numeric
if (isset($_POST['friendID']) && is_numeric($_POST['friendID'])) {
    // Get the user ID from the session (assuming it's an integer)
    $userID = (int)$_SESSION['userID'];
    // Get the friend ID from the request (assuming it's an integer)
    $friendID = (int)$_POST['friendID'];

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to check if the friendship already exists
        $stmt = $conn->prepare("SELECT COUNT(*) FROM friendship WHERE (user1 = :userID AND user2 = :friendID) OR (user2 = :userID AND user1 = :friendID)");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':friendID', $friendID, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the count of existing friendships
        $existingFriendships = $stmt->fetchColumn();

        // If the friendship doesn't exist, add it
        if ($existingFriendships == 0) {
            $stmt = $conn->prepare("INSERT INTO friendship (user1, user2) VALUES (:userID, :friendID)");
            $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
            $stmt->bindParam(':friendID', $friendID, PDO::PARAM_INT);
            $stmt->execute();
            $response = array("success" => true, "message" => "Friend added successfully.");
        } else {
            $response = array("success" => false, "message" => "Friendship already exists.");
        }
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        error_log("Error adding friend: " . $e->getMessage());
        // Return a generic error message
        $response = array("success" => false, "message" => "An error occurred while processing your request. Please try again later.");
    }

    echo json_encode($response);
    exit;
} else {
    // Invalid or missing friend ID, exit gracefully
    $response = array('success' => false, 'message' => "Invalid or missing friend ID");
    echo json_encode($response);
    exit;
}
?>