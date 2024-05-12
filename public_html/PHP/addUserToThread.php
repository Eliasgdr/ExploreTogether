<?php
// Database connection parameters
include 'databaseConnection.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    echo json_encode(array('success' => false, 'message' => "User not logged in"));
    exit;
}

// Check if thread ID and user ID are provided in the request and are numeric
if (isset($_POST['threadID']) && is_numeric($_POST['threadID']) && isset($_POST['userID']) && is_numeric($_POST['userID'])) {
    // Get the user ID and thread ID from the session and request (assuming they're integers)
    $userID = (int)$_SESSION['userID'];
    $threadID = (int)$_POST['threadID'];
    $memberID = (int)$_POST['userID'];

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to check if the user is already added to the thread
        $stmt = $conn->prepare("SELECT COUNT(*) FROM threadSubscriptions WHERE threadID = :threadID AND userID = :memberID");
        $stmt->bindParam(':threadID', $threadID, PDO::PARAM_INT);
        $stmt->bindParam(':memberID', $memberID, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the count of existing memberships
        $existingMemberships = $stmt->fetchColumn();

        // If the user is not already added to the thread, add them
        if ($existingMemberships == 0) {
            $stmt = $conn->prepare("INSERT INTO threadSubscriptions (threadID, userID) VALUES (:threadID, :memberID)");
            $stmt->bindParam(':threadID', $threadID, PDO::PARAM_INT);
            $stmt->bindParam(':memberID', $memberID, PDO::PARAM_INT);
            $stmt->execute();
            echo json_encode(array('success' => true, 'message' => "User added to thread successfully."));
        } else {
            echo json_encode(array('success' => false, 'message' => "User is already a member of the thread."));
        }
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        error_log("Error adding user to thread: " . $e->getMessage());
        // Display a generic error message to the user
        echo json_encode(array('success' => false, 'message' => "An error occurred while processing your request. Please try again later."));
    }
} else {
    // Invalid or missing thread ID or user ID
    echo json_encode(array('success' => false, 'message' => "Invalid or missing thread ID or user ID."));
    exit;
}
?>