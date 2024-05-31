<?php
// Database connection parameters
include 'databaseConnection.php';
include 'adminlib.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(array('success' => false, 'status_text' => "User not logged in.", 'status_code' => 401));
    exit;
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $messageID = $_POST["messageID"];
    $userID = (int)$_SESSION['userID'];

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the user is an admin
        if (!isAdmin($userID, $conn)) {
            http_response_code(401); // Unauthorized
            echo json_encode(array('success' => false, 'status_text' => "User is not an Admin", 'status_code' => 401));
            exit;
        }

        // Check if the message exists
        $stmt = $conn->prepare("SELECT messageID FROM message WHERE messageID = :messageID");
        $stmt->bindParam(':messageID', $messageID, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            http_response_code(404); // Not Found
            echo json_encode(array('success' => false, 'status_text' => "Message not found.", 'status_code' => 404));
            exit;
        }

        // Delete the message from the database
        $stmt = $conn->prepare("DELETE FROM message WHERE messageID = :messageID");
        $stmt->bindParam(':messageID', $messageID, PDO::PARAM_INT);
        $stmt->execute();

        // Prepare success response
        http_response_code(200); // OK
        echo json_encode(array('success' => true, 'status_text' => "Message deleted successfully.", 'status_code' => 200));
        exit;
    } catch (PDOException $e) {
        // Handle database connection errors
        http_response_code(500); // Internal Server Error
        echo json_encode(array('success' => false, 'status_text' => "Error: " . $e->getMessage(), 'status_code' => 500));
        exit;
    }
} else {
    // Prepare response for invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('success' => false, 'status_text' => "Invalid request method.", 'status_code' => 405));
    exit;
}
?>