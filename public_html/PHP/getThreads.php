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
    // Return JSON response
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

    // Retrieve threads user is following from the database
    $stmt = $conn->prepare("SELECT * FROM threads WHERE threadID IN (SELECT threadID FROM threadSubscriptions WHERE userID = :user_id)");
    $stmt->bindParam(':user_id', $_SESSION['userID']); 
    $stmt->execute();
    $threads = $stmt->fetchAll();

    // Initialize array to store thread information
    $threadInfo = array();
    // Store thread information
    foreach ($threads as $thread) {
        $lastMessageID = $thread['lastMessageID'];
        $stmt2 = $conn->prepare("SELECT * FROM message WHERE messageID = :lastMessageID");
        $stmt2->bindParam(':lastMessageID',  $lastMessageID); 
        $stmt2->execute();
        $message = $stmt2->fetch();

        // Store thread information in an array
        $threadData = array(
            'threadID' => $thread['threadID'],
            'lastMessage' => $message['body'],
            'lastMessageDate' => $message['Date']
            // Add other information about the thread if needed
        );
        // Push thread data into the thread info array
        $threadInfo[] = $threadData;
    }

    // Set success response
    $response['success'] = true;
    // Set thread information in the response
    $response['threadInfo'] = $threadInfo;
    // Set success message
    $response['message'] = "Thread information retrieved successfully.";

} catch(PDOException $e) {
    // Set error response
    $response['success'] = false;
    $response['message'] = "Error: " . $e->getMessage();
}

// Return JSON response
echo json_encode($response);

// Close database connection
$conn = null;
?>