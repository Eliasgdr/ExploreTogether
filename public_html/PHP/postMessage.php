<?php
include 'databaseConnection.php';

// Start the session
session_start();

// Initialize response array
$response = array();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    $response['success'] = false;
    $response['message'] = "User not logged in.";
    echo json_encode($response);
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $message = trim($_POST["message"]);
    $threadID = $_POST["threadID"];

    // Validate message content (add your own validation rules as needed)
    if (empty($message)) {
        $response['success'] = false;
        $response['message'] = "Message content is required.";
        echo json_encode($response);
        exit;
    } else {
        try {
            // Create a new PDO connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insert the message into the database
            $stmt = $conn->prepare("INSERT INTO message (threadID, authorID, body, Date) VALUES (:chatID, :authorID, :body, NOW())");
            $stmt->bindParam(':chatID', $threadID);
            $stmt->bindParam(':authorID', $_SESSION['userID']);
            $stmt->bindParam(':body', $message);
            $stmt->execute();

            $messageID = $conn->lastInsertId();

            $stmt = $conn->prepare("UPDATE threads SET lastMessageID = :lastMessageID WHERE threadID = :chatID");
            $stmt->bindParam(':lastMessageID', $messageID);
            $stmt->bindParam(':chatID', $threadID);
            $stmt->execute();

            // Prepare success response
            $response['success'] = true;
            $response['message'] = "Message posted successfully.";
            echo json_encode($response);
            exit;
        } catch (PDOException $e) {
            // Handle database connection errors
            $response['success'] = false;
            $response['message'] = "Error: " . $e->getMessage();
            echo json_encode($response);
            exit;
        }
    }
} else {
    // Prepare response for invalid request
    $response['success'] = false;
    $response['message'] = "Invalid request.";
    echo json_encode($response);
    exit;
}
?>