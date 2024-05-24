<?php

include 'databaseConnection.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    http_response_code(401); // Unauthorized status code
    echo json_encode(array('success' => false, 'status_text' => "User not logged in", 'status_code' => 401));
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

        // Prepare SQL statement to remove the friendship
        $stmt = $conn->prepare("DELETE FROM friendship WHERE (user1 = :userID AND user2 = :friendID) OR (user2 = :userID AND user1 = :friendID)");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':friendID', $friendID, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any friendship was removed
        if ($stmt->rowCount() > 0) {
            echo json_encode(array('success' => true, 'status_text' => "Friend removed successfully", 'status_code' => 200));
        } else {
            echo json_encode(array('success' => false, 'status_text' => "Friendship does not exist", 'status_code' => 404));
        }
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        error_log("Error removing friend: " . $e->getMessage());
        // Display a generic error message to the user
        http_response_code(500); // Internal server error status code
        echo json_encode(array('success' => false, 'status_text' => "Error: " . $e->getMessage(), 'status_code' => 500));
    }
} else {
    // Invalid or missing friend ID, exit gracefully
    http_response_code(400); // Bad request status code
    echo json_encode(array('success' => false, 'status_text' => "Invalid or missing friend ID", 'status_code' => 400));
    exit;
}
?>