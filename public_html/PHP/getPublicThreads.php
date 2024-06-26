<?php
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

    // Retrieve threads user is following and are public from the database
    $stmt = $conn->prepare("SELECT * FROM threads WHERE threadID IN (SELECT threadID FROM threadSubscriptions WHERE userID = :user_id) AND isPublic = 1");
    $stmt->bindParam(':user_id', $_SESSION['userID'], PDO::PARAM_INT); 
    $stmt->execute();
    $threads = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize array to store thread information
    $threadInfo = array();

    // Store thread information
    foreach ($threads as $thread) {
        $lastMessageID = $thread['lastMessageID'];
        $stmt2 = $conn->prepare("SELECT * FROM message WHERE messageID = :lastMessageID");
        $stmt2->bindParam(':lastMessageID', $lastMessageID, PDO::PARAM_INT); 
        $stmt2->execute();
        $message = $stmt2->fetch(PDO::FETCH_ASSOC);

        // Check if message exists
        if ($message) {
            // Store thread information in an array
            $threadData = array(
                'threadID' => $thread['threadID'],
                'lastMessage' => $message['body'],
                'lastMessageDate' => $message['Date']
                // Add other information about the thread if needed
            );
        } else {
            // Handle case where last message does not exist
            $threadData = array(
                'threadID' => $thread['threadID'],
                'lastMessage' => null,
                'lastMessageDate' => null
            );
        }
        // Push thread data into the thread info array
        $threadInfo[] = $threadData;
    }

    // Set success response
    $response['success'] = true;
    // Set thread information in the response
    $response['threadInfo'] = $threadInfo;
    // Set success message
    $response['message'] = "Thread information retrieved successfully.";

    // Return JSON response with 200 status code (OK)
    http_response_code(200);
    echo json_encode($response);
    exit;

} catch(PDOException $e) {
    // Set error response
    $response['success'] = false;
    $response['message'] = "Error: " . $e->getMessage();
    // Return JSON response with 500 status code (Internal Server Error)
    http_response_code(500);
    echo json_encode($response);
    exit;
}
?>