<?php
// Database connection parameters
include 'databaseConnection.php';

// Start the session
session_start();

// Initialize response array
$response = array();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    $response['success'] = false;
    $response['message'] = "User not logged in";
    http_response_code(401); // Unauthorized status code
    echo json_encode($response);
    exit;
}

// Check if the thread ID is provided in the request
if (!isset($_POST['thread_id'])) {
    $response['success'] = false;
    $response['message'] = "Thread ID is missing";
    http_response_code(400); // Bad request status code
    echo json_encode($response);
    exit;
}

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve messages for the thread
    $stmt = $conn->prepare("SELECT * FROM message WHERE threadID = :thread_id ORDER BY Date DESC");
    $stmt->bindParam(':thread_id', $_POST['thread_id']);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare JSON response array for messages
    $response['success'] = true;
    $response['message'] = "Messages retrieved successfully";
    $response['messages'] = array();

    // Loop through messages
    foreach ($messages as $message) {
        // Retrieve author details
        $stmt = $conn->prepare("SELECT * FROM users WHERE ID = :messageUserID");
        $stmt->bindParam(':messageUserID', $message['authorID']);
        $stmt->execute();
        $author = $stmt->fetch();

        // Prepare message data
        $messageData = array(
            'author' => $author !== false ? htmlspecialchars($author['username']) : 'Unknown',
            'time' => htmlspecialchars($message['Date']),
            'body' => htmlspecialchars($message['body'])
        );

        // Add message data to response array
        $response['messages'][] = $messageData;
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    // Handle database connection errors
    $response['success'] = false;
    $response['message'] = "An error occurred while processing your request";
    http_response_code(500); // Internal server error status code
    echo json_encode($response);
}
?>