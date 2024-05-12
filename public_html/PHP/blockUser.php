<?php
// Database connection parameters
$servername = "localhost";
$username = "id22104896_jsp";
$password = "Test@123";
$dbname = "id22104896_jsp";

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: ../login.php"); // Redirect to login page if not logged in
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
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':userIDToBlock', $userIDToBlock, PDO::PARAM_INT);

        // Execute statement
        $stmt->execute();

        echo "User blocked successfully";
    } else {
        echo "User ID not provided";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection (not necessary for PDO, but good practice)
$pdo = null;
?>