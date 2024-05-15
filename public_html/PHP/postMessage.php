<?php
include 'databaseConnection.php';

// Start the session
session_start();

// Initialize response array
$response = array();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(array('success' => false, 'status_text' => "User not logged in.", 'status_code' => 401));
    exit;
}

if (!isset($_POST['threadID']) || !ctype_digit($_POST['threadID'])) { //ctype_digit return true if the string only contains digits(The idea is to cked if the numer is a int)
    $response['success'] = false;
    $response['message'] = "Thread ID is missing";
    http_response_code(400); // Bad request status code
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
        http_response_code(400); // Bad Request
        echo json_encode(array('success' => false, 'status_text' => "Message content is required.", 'status_code' => 400));
        exit;
    } else {
        try {
            // Create a new PDO connection
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the user has access to the thread
            $stmt = $conn->prepare("SELECT * FROM threadsubscriptions WHERE userID = :userID AND threadID = :threadID");
            $stmt->bindParam(':userID', $_SESSION['userID']);
            $stmt->bindParam(':threadID', $threadID);
            $stmt->execute();
            $participant = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$participant) {
                http_response_code(403); // Forbidden
                echo json_encode(array('success' => false, 'status_text' => "You do not have access to this thread", 'status_code' => 403));
                exit;
            }

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
            echo json_encode(array('success' => true, 'message' => "Message posted successfully."));
            exit;
        } catch (PDOException $e) {
            // Handle database connection errors
            http_response_code(500); // Internal Server Error
            echo json_encode(array('success' => false, 'status_text' => "Error: " . $e->getMessage(), 'status_code' => 500));
            exit;
        }
    }
} else {
    // Prepare response for invalid request
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('success' => false, 'status_text' => "Invalid request.", 'status_code' => 405));
    exit;
}
?>