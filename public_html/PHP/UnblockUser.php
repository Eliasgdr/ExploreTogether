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

    // Get user ID to unblock from the HTML form
    if (isset($_POST['userIDToUnblock'])) {
        $user_id = $_SESSION['userID'];
        $userIDToUnblock = $_POST['userIDToUnblock'];

        // SQL query to delete blocked user entry
        $sql = "DELETE FROM blockedUsers WHERE userID = :userID AND blockedUserID = :userIDToUnblock";

        // Prepare statement
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':userIDToUnblock', $userIDToUnblock, PDO::PARAM_INT);

        // Execute statement
        $stmt->execute();

        echo "User unblocked successfully";
    } else {
        echo "User ID not provided";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection (not necessary for PDO, but good practice)
$pdo = null;
?>