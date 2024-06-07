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

// Check if threadID is provided
if (!isset($_POST['threadID'])) {
    // Set error response
    $response['success'] = false;
    $response['message'] = "Thread ID not provided";
    // Return JSON response with 400 status code (Bad Request)
    http_response_code(400);
    echo json_encode($response);
    exit;
}

// Get thread ID from POST request
$threadID = $_POST['threadID'];

// Database connection parameters
include 'databaseConnection.php';
include 'admin/adminlib.php';

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    if(isAdmin($_SESSION['userID'], $conn)) {
            $stmt = $conn->prepare("
            SELECT t.*, u.username AS ownerUsername, u.profileImage AS ownerProfileImage 
            FROM threads t
            JOIN users u ON t.ownerID = u.ID
            WHERE t.threadID = :thread_id
        "); 
        $stmt->bindParam(':thread_id', $threadID);
        $stmt->execute();
        $thread = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Retrieve the specific thread and its owner the user is following from the database
        $stmt = $conn->prepare("
            SELECT t.*, u.username AS ownerUsername, u.profileImage AS ownerProfileImage 
            FROM threads t
            JOIN users u ON t.ownerID = u.ID
            WHERE t.threadID = :thread_id AND t.threadID IN (SELECT threadID FROM threadSubscriptions WHERE userID = :user_id)
        ");
        $stmt->bindParam(':thread_id', $threadID);
        $stmt->bindParam(':user_id', $_SESSION['userID']);
        $stmt->execute();
        $thread = $stmt->fetch(PDO::FETCH_ASSOC);

    }

    if ($thread) {
        // Retrieve all messages of the thread along with author username and profile image
        $stmt2 = $conn->prepare("
            SELECT m.*, u.username AS authorUsername, u.profileImage AS authorProfileImage 
            FROM message m
            JOIN users u ON m.authorID = u.ID
            WHERE m.threadID = :thread_id
            ORDER BY m.Date ASC
        ");
        $stmt2->bindParam(':thread_id', $threadID);
        $stmt2->execute();
        $messages = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // Initialize array to store thread and messages information
        $threadInfo = array(
            'threadID' => $thread['threadID'],
            'title' => $thread['title'],
            'description' => $thread['description'],
            'isPublic' => $thread['isPublic'],
            'isDM' => $thread['isDM'],
            'ownerID' => $thread['ownerID'],
            'ownerUsername' => $thread['ownerUsername'],
            'ownerProfileImage' => $thread['ownerProfileImage'],
            'messages' => $messages
        );

        // Set success response
        $response['success'] = true;
        // Set thread information in the response
        $response['threadInfo'] = $threadInfo;
        // Set success message
        $response['message'] = "Thread and messages information retrieved successfully.";

        // Return JSON response with 200 status code (OK)
        http_response_code(200);
        echo json_encode($response);
        exit;
    } else {
        // Set error response if the thread is not found or not subscribed to
        $response['success'] = false;
        $response['message'] = "Thread not found or not subscribed to f  " . isAdmin($_SESSION['userID'], $conn);
        // Return JSON response with 404 status code (Not Found)
        http_response_code(404);
        echo json_encode($response);
        exit;
    }
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