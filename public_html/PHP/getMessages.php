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
if (!isset($_POST['thread_id']) || !ctype_digit($_POST['thread_id'])) { //ctype_digit return true if the string only contains digits(The idea is to cked if the numer is a int)
    $response['success'] = false;
    $response['message'] = "Thread ID is missing";
    http_response_code(400); // Bad request status code
    echo json_encode($response);
    exit;
}
// Check if limit is provided and is an integer
if (!isset($_POST['limit']) || !ctype_digit($_POST['limit'])) {
    $response['success'] = false;
    $response['message'] = "Limit parameter is missing or invalid";
    http_response_code(400); // Bad request status code
    echo json_encode($response);
    exit;
}

// Check if offset is provided and is an integer
if (!isset($_POST['offset']) || !ctype_digit($_POST['offset'])) {
    $response['success'] = false;
    $response['message'] = "Offset parameter is missing or invalid";
    http_response_code(400); // Bad request status code
    echo json_encode($response);
    exit;
}

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the user has access to the thread
    $stmt = $conn->prepare("SELECT * FROM threadsubscriptions WHERE userID = :userID AND threadID = :threadID");
    $stmt->bindParam(':userID', $_SESSION['userID']);
    $stmt->bindParam(':threadID', $_POST['thread_id']);
    $stmt->execute();
    $participant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$participant) {
        $response['success'] = false;
        $response['message'] = "You do not have access to this thread";
        http_response_code(403); // Forbidden status code
        echo json_encode($response);
        exit;
    }





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
            'authorID' => htmlspecialchars($author['ID']),
            'time' => htmlspecialchars($message['Date']),
            'body' => htmlspecialchars($message['body']),
            'id' => htmlspecialchars($message['messageID'])
        );

        // Add message data to response array
        $response['messages'][] = $messageData;
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