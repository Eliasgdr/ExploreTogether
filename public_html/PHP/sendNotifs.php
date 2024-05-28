<?php

/*
Notif code : 1 -> message
             2 -> friend request


*/
// Start the session
session_start();

// Initialize response array
$response = array();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Set error response
    $response['success'] = false;
    $response['message'] = "User not logged in";
    // Return JSON response with 401 status code (Unauthorized)
    http_response_code(401);
    echo json_encode($response);
    exit;
}

// Database connection parameters
include 'databaseConnection.php';

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get data from POST request
    if (isset($_POST['recipientID']) && isset($_POST['messageContent']) && isset($_POST['messageLink'])) {
        // Validate recipient ID
        $recipientID = filter_var($_POST['recipientID'], FILTER_VALIDATE_INT);
        if ($recipientID === false) {
            throw new Exception("Invalid recipient ID.");
        }

        // Validate message content
        $messageContent = trim($_POST['messageContent']);
        if (empty($messageContent) || strlen($messageContent) > 535) {
            throw new Exception("Invalid message content.");
        }

        // Validate message link
        $messageLink = filter_var($_POST['messageLink'], FILTER_VALIDATE_URL);
        if ($messageLink === false || strlen($messageLink) > 535) {
            throw new Exception("Invalid message link.");
        }

        // Sender ID is the logged-in user
        $senderID = $_SESSION['userID']; 
        $notifCode = $_SESSION['notifCode']; ; // Assuming 1 represents a message received notification

        // SQL query to insert new notification
        $sql = "INSERT INTO notifs (userID, senderID, content, link, notifCode) VALUES (:userID, :senderID, :content, :link, :notifCode)";
        
        // Prepare statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':userID', $recipientID, PDO::PARAM_INT);
        $stmt->bindParam(':senderID', $senderID, PDO::PARAM_INT);
        $stmt->bindParam(':content', $messageContent, PDO::PARAM_STR);
        $stmt->bindParam(':link', $messageLink, PDO::PARAM_STR);
        $stmt->bindParam(':notifCode', $notifCode, PDO::PARAM_INT);

        // Execute statement
        $stmt->execute();

        // Set success response
        $response['success'] = true;
        $response['message'] = "Notification created successfully.";
        
        // Return JSON response with 200 status code (OK)
        http_response_code(200);
        echo json_encode($response);
        exit;
    } else {
        // Set error response
        $response['success'] = false;
        $response['message'] = "Required data not provided";
        // Return JSON response with 400 status code (Bad Request)
        http_response_code(400);
        echo json_encode($response);
        exit;
    }
} catch(Exception $e) {
    // Set error response
    $response['success'] = false;
    $response['message'] = "Error: " . $e->getMessage();
    // Return JSON response with 400 status code (Bad Request) for validation errors or 500 for other exceptions
    if ($e->getCode() == 0) {
        http_response_code(400);
    } else {
        http_response_code(500);
    }
    echo json_encode($response);
    exit;
}
?>