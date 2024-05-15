<?php
// Database connection parameters
include 'databaseConnection.php';

// Start the session
session_start();

$response = array();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Set response indicating user not logged in
    http_response_code(401); // Unauthorized
    echo json_encode(array('success' => false, 'status_text' => "User not logged in", 'status_code' => 401));
    exit;
} else {
    // Check if the thread ID is provided in the URL
    if (isset($_POST['threadID']) && ctype_digit($_POST['threadID'])) {
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
            echo json_encode(array('success' => true, 'message' => "Thread updated successfully."));
            exit;
        } catch (PDOException $e) {
            // Handle database connection errors
            http_response_code(500); // Internal Server Error
            echo json_encode(array('success' => false, 'status_text' => "Database error: " . $e->getMessage(), 'status_code' => 500));
            exit;
        }
    } else {
        // Set response indicating missing thread ID
        http_response_code(400); // Bad Request
        echo json_encode(array('success' => false, 'status_text' => "Thread ID not provided", 'status_code' => 400));
        exit;
    }
}
?>