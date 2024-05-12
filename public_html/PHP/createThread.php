<?php
// Database connection parameters
include 'databaseConnection.php';

// Start the session
session_start();

header('Content-Type: json');
$response = array(); // Initialize an empty array for the response

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Redirect to login page if not logged in
    $response = array('success' => false, 'message' => "User not logged in");
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
        $response = array('success' => false, 'message' => "Title and description are required.");
        echo json_encode($response);
        exit;
    } else {
        try {
            // Create a new PDO connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insert the new thread into the database
            $stmt = $conn->prepare("INSERT INTO threads (title, description, lastMessageID) VALUES (:title, :description, NULL)");
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->execute();
            
            $threadID = $conn->lastInsertId();
            
            // Update the users table to add the new thread ID to the chats field
            
            $stmt = $conn->prepare("INSERT INTO threadSubscriptions (userID, threadID) VALUES (:userID, :threadID)");
            //Old version
            //$stmt = $conn->prepare("UPDATE users SET threads = CONCAT(threads, ',', :threadID) WHERE ID = :userID");
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
            
            // Add success message to the response
            $response = array('success' => true, 'message' => "Thread created successfully.");
            echo json_encode($response);
            exit;
        } catch (PDOException $e) {
            // Handle database connection errors
            $response = array('success' => false, 'message' => "Error: " . $e->getMessage());
            echo json_encode($response);
            exit;
        }
    }
} else {
    // Redirect to the welcome page if the form is not submitted
    $response = array('success' => false, 'message' => "Error: Invalid request method");
    echo json_encode($response);
    exit;
}
?>