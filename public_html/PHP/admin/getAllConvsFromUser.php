<?php
// Database connection parameters
include 'databaseConnection.php';
include 'adminlib.php'; // Include admin library for admin check

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

// Check if the user is an admin
$userID = (int)$_SESSION['userID'];
if (!isAdmin($userID, $conn)) {
    $response['success'] = false;
    $response['message'] = "User is not an admin";
    http_response_code(403); // Forbidden status code
    echo json_encode($response);
    exit;
}

// Check if the user ID is provided in the request and is numeric
if (!isset($_POST['user_id']) || !ctype_digit($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User ID is missing or invalid";
    http_response_code(400); // Bad request status code
    echo json_encode($response);
    exit;
}

// Validate and sanitize input
$userID = (int)$_POST['user_id'];

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve threads for the user
    $stmt = $conn->prepare("SELECT threadID FROM threadsubscriptions WHERE userID = :userID");
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
    $stmt->execute();
    $threads = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Prepare JSON response array for messages
    $response['success'] = true;
    $response['message'] = "Messages retrieved successfully";
    $response['messages'] = array();

    // Loop through threads
    foreach ($threads as $thread) {
        // Retrieve messages for each thread
        $stmt = $conn->prepare("SELECT * FROM message WHERE threadID = :threadID ORDER BY Date DESC");
        $stmt->bindParam(':threadID', $thread['threadID'], PDO::PARAM_INT);
        $stmt->execute();
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Loop through messages
        foreach ($messages as $message) {
            // Retrieve author details
            $stmt = $conn->prepare("SELECT * FROM users WHERE ID = :messageUserID");
            $stmt->bindParam(':messageUserID', $message['authorID'], PDO::PARAM_INT);
            $stmt->execute();
            $author = $stmt->fetch(PDO::FETCH_ASSOC);

            // Prepare message data
            $messageData = array(
                'author' => $author !== false ? htmlspecialchars($author['username']) : 'Unknown',
                'authorID' => htmlspecialchars($author['ID']),
                'time' => htmlspecialchars($message['Date']),
                'body' => htmlspecialchars($message['body']),
                'id' => htmlspecialchars($message['messageID'])
            );

            // Add message data to response array
            $response['messages'][] = $messageData;
        }
    }

    // Return JSON response with 200 status code (OK)
    http_response_code(200);
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