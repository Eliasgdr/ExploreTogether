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

    // Get user ID to unblock from the HTML form
    if (isset($_POST['userIDToUnblock'])) {
        $user_id = $_SESSION['userID'];
        $userIDToUnblock = $_POST['userIDToUnblock'];

        // SQL query to delete blocked user entry
        $sql = "DELETE FROM blockedUsers WHERE userID = :userID AND blockedUserID = :userIDToUnblock";

        // Prepare statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':userID', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':userIDToUnblock', $userIDToUnblock, PDO::PARAM_INT);

        // Execute statement
        $stmt->execute();

        echo json_encode(array('success' => true, 'message' => "User unblocked successfully"));
    } else {
        http_response_code(400);
        echo json_encode(array('success' => false, 'status_text' => "User ID not provided", 'status_code' => 400));
    }
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(array('success' => false, 'status_text' => "Error: " . $e->getMessage(), 'status_code' => 500));
}

// Close connection (not necessary for PDO, but good practice)
$pdo = null;
?>