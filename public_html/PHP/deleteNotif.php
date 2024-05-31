<?php

// Database connection parameters
include 'databaseConnection.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    http_response_code(401);
    echo json_encode(array('success' => false, 'status_text' => "User not logged in", 'status_code' => 401));
    exit;
}

try {
    // Create connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get notification ID to delete from the HTML form
    if (isset($_POST['notifIDToDelete'])) {
        $notifIDToDelete = $_POST['notifIDToDelete'];

        // SQL query to delete notification
        $sql = "DELETE FROM notifs WHERE notifID = :notifID";

        // Prepare statement
        $stmt = $pdo->prepare($sql);

        // Bind parameter
        $stmt->bindParam(':notifID', $notifIDToDelete, PDO::PARAM_INT);

        // Execute statement
        $stmt->execute();

        // Check if the notification was deleted
        if ($stmt->rowCount() > 0) {
            // Notification deleted successfully
            echo json_encode(array('success' => true, 'message' => "Notification deleted successfully"));
        } else {
            // Notification not found or already deleted
            http_response_code(404);
            echo json_encode(array('success' => false, 'status_text' => "Notification not found", 'status_code' => 404));
        }
    } else {
        // Notification ID not provided
        http_response_code(400);
        echo json_encode(array('success' => false, 'status_text' => "Notification ID not provided", 'status_code' => 400));
    }
} catch(PDOException $e) {
    // Internal Server Error
    http_response_code(500);
    echo json_encode(array('success' => false, 'status_text' => "Error: " . $e->getMessage(), 'status_code' => 500));
}

// Close connection (not necessary for PDO, but good practice)
$pdo = null;

?>