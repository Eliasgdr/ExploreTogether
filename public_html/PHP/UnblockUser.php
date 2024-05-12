<?php

// Database connection parameters
include 'databaseConnection.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    echo json_encode(array('success' => false, 'message' => "User not logged in"));
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
        echo json_encode(array('success' => false, 'message' => "User ID not provided"));
    }
} catch(PDOException $e) {
    echo json_encode(array('success' => false, 'message' => "Error: " . $e->getMessage()));
}

// Close connection (not necessary for PDO, but good practice)
$pdo = null;
?>