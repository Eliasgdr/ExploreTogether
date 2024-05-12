<?php
// Database connection parameters
include 'databaseConnection.php';

// Start the session
session_start();

$response = array();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Set response indicating user not logged in
    $response = array('success' => false, 'message' => "User not logged in");
} else {
    // Check if the thread ID is provided in the URL
    if (isset($_POST['threadID'])) {
        // Get the user ID from the session
        $userID = $_SESSION['userID'];
        // Get the thread ID from the URL
        $threadID = $_POST['threadID'];

        try {
            // Create a new PDO connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare SQL statement to update the user's threads
            $stmt = $conn->prepare("DELETE FROM threadSubscriptions WHERE userID = :userID AND threadID = :threadID");
            $stmt->bindParam(':threadID', $threadID);
            $stmt->bindParam(':userID', $userID);
            
            // Execute the SQL statement
            $stmt->execute();

            // Set success response
            $response = array('success' => true, 'message' => "Thread updated successfully.");
        } catch (PDOException $e) {
            // Handle database connection errors
            $response = array('success' => false, 'message' => "Database error: " . $e->getMessage());
        }
    } else {
        // Set response indicating missing thread ID
        $response = array('success' => false, 'message' => "Thread ID not provided");
    }
}

// Output JSON response
echo json_encode($response);
?>
