<?php

include 'databaseConnection.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(array('success' => false, 'status_text' => "User not logged in", 'status_code' => 401));
    exit;
}

try {
    // Create connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get user ID to block from the HTML form
    if (isset($_POST['userIDToBlock'])) {
        $user_id = $_SESSION['userID'];
        $userIDToBlock = $_POST['userIDToBlock'];

        // SQL query to update user status to blocked
        $sql = "INSERT INTO blockedUsers (userID, blockedUserID) VALUES (:userID, :userIDToBlock)";

        // Prepare statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':userID', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':userIDToBlock', $userIDToBlock, PDO::PARAM_INT);

        // Execute statement
        $stmt->execute();

        http_response_code(200); // OK
        echo json_encode(array('success' => true, 'status_text' => "User blocked successfully", 'status_code' => 200));
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(array('success' => false, 'status_text' => "User ID not provided", 'status_code' => 400));
    }
} catch(PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(array('success' => false, 'status_text' => "Error: " . $e->getMessage(), 'status_code' => 500));
}

// Close connection (not necessary for PDO, but good practice)
$pdo = null;
?>