<?php
// Database connection parameters
include 'databaseConnection.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(array('success' => false, 'status_text' => "User not logged in", 'status_code' => 401));
    exit;
}

// Check if thread ID and content are provided in the request
if (isset($_POST['threadID']) && is_numeric($_POST['threadID']) && isset($_POST['content'])) {
    // Get the user ID from the session and the thread ID and content from the request
    $fromUserID = (int)$_SESSION['userID'];
    $threadID = (int)$_POST['threadID'];
    $content = $_POST['content'];

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to insert the report into the database
        $stmt = $conn->prepare("INSERT INTO reports (fromUserID, threadID, content) VALUES (:fromUserID, :threadID, :content)");
        $stmt->bindParam(':fromUserID', $fromUserID, PDO::PARAM_INT);
        $stmt->bindParam(':threadID', $threadID, PDO::PARAM_INT);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->execute();

        http_response_code(200); // OK
        echo json_encode(array('success' => true, 'status_text' => "Report added successfully.", 'status_code' => 200));
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        //error_log("Error adding report: " . $e->getMessage());
        // Display a generic error message to the user
        http_response_code(500); // Internal Server Error
        echo json_encode(array('success' => false, 'status_text' => "An error occurred while processing your request. Please try again later." . $e->getMessage(), 'status_code' => 500));
    }
} else {
    // Invalid or missing thread ID or content
    http_response_code(400); // Bad Request
    echo json_encode(array('success' => false, 'status_text' => "Invalid or missing thread ID or content.", 'status_code' => 400));
    exit;
}
?>