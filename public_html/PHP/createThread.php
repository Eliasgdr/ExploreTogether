<?php
// Database connection parameters
include 'databaseConnection.php';

// Start the session
session_start();

// Set content type to JSON
header('Content-Type: application/json');

$response = array(); // Initialize an empty array for the response

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Unauthorized status code
    http_response_code(401);
    // Response message
    $response = array('success' => false, 'status_text' => "User not logged in");
    echo json_encode($response);
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $title = trim($_POST["title"]);
    $description = trim($_POST["description"]);
    $userID = $_SESSION['userID'];

    // Validate input (add your own validation rules as needed)
    if (empty($title) || empty($description)) {
        // Bad Request status code
        http_response_code(400);
        // Response message
        $response = array('success' => false, 'status_text' => "Title and description are required.");
        echo json_encode($response);
        exit;
    } else {
        try {
            // Create a new PDO connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insert the new thread into the database
            $stmt = $conn->prepare("INSERT INTO threads (title, description, lastMessageID, ownerID) VALUES (:title, :description, NULL, :ownerID)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':ownerID', $userID);
            $stmt->execute();
            
            $threadID = $conn->lastInsertId();
            
            // Update the users table to add the new thread ID to the chats field
            
            $stmt = $conn->prepare("INSERT INTO threadSubscriptions (userID, threadID) VALUES (:userID, :threadID)");
            $stmt->bindParam(':threadID', $threadID);
            $stmt->bindParam(':userID', $userID);
            $stmt->execute();
            
            // Create an init message
            // Insert the message into the database
            $messageBody = "Hi, I just created a new Thread named $title";
            $stmt = $conn->prepare("INSERT INTO message (threadID, authorID, body, Date) VALUES (:chatID, :authorID, :body, NOW())");
            $stmt->bindParam(':chatID', $threadID);
            $stmt->bindParam(':authorID', $userID);
            $stmt->bindParam(':body', $messageBody);
            $stmt->execute();
            
            //Update lastMessage of the Thread
            $messageID = $conn->lastInsertId();
            $stmt = $conn->prepare("UPDATE threads SET lastMessageID = :lastMessageID WHERE threadID = :chatID");
            $stmt->bindParam(':lastMessageID', $messageID);
            $stmt->bindParam(':chatID', $threadID);
            $stmt->execute();
            
            // Success response
            http_response_code(200); 
            $response = array('success' => true, 'status_text' => "Thread created successfully.");
            echo json_encode($response);
            exit;
        } catch (PDOException $e) {
            // Database error response
            http_response_code(500); // Internal Server Error
            $response = array('success' => false, 'status_text' => "Error: " . $e->getMessage());
            echo json_encode($response);
            exit;
        }
    }
} else {
    // Invalid request method response
    http_response_code(400); // Bad Request
    $response = array('success' => false, 'status_text' => "Invalid request method");
    echo json_encode($response);
    exit;
}
?>