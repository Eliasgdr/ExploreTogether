<?php
include 'databaseConnection.php';

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
    $newMessage = trim($_POST["newMessage"]);

    // Validate message content (add your own validation rules as needed)
    if (empty($newMessage)) {
        http_response_code(400); // Bad Request
        echo json_encode(array('success' => false, 'status_text' => "New message content is required.", 'status_code' => 400));
        exit;
    }

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the message exists and the current user is the author
        $stmt = $conn->prepare("SELECT authorID FROM message WHERE messageID = :messageID");
        $stmt->bindParam(':messageID', $messageID);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            http_response_code(404); // Not Found
            echo json_encode(array('success' => false, 'status_text' => "Message not found.", 'status_code' => 404));
            exit;
        }

        // Check if the current user is the author of the message
        if ($row['authorID'] != $_SESSION['userID']) {
            http_response_code(403); // Forbidden
            echo json_encode(array('success' => false, 'status_text' => "You are not authorized to edit this message.", 'status_code' => 403));
            exit;
        }

        // Update the message content in the database
        $stmt = $conn->prepare("UPDATE message SET body = :newMessage WHERE messageID = :messageID");
        $stmt->bindParam(':newMessage', $newMessage);
        $stmt->bindParam(':messageID', $messageID);
        $stmt->execute();

        // Prepare success response
        echo json_encode(array('success' => true, 'status_text' => "Message edited successfully.", 'status_code' => 200));
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