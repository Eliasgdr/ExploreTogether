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

// Check if friend ID is provided in the request and is numeric
if (isset($_POST['friendID']) && is_numeric($_POST['friendID'])) {
    // Get the user ID from the session (assuming it's an integer)
    $userID = (int)$_SESSION['userID'];
    // Get the friend ID from the request (assuming it's an integer)
    $friendID = (int)$_POST['friendID'];

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to remove the friendship
        $stmt = $conn->prepare("DELETE FROM friendship WHERE (user1 = :userID AND user2 = :friendID) OR (user2 = :userID AND user1 = :friendID)");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':friendID', $friendID, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any friendship was removed
        if ($stmt->rowCount() > 0) {
            echo "Friend removed successfully.";
        } else {
            echo "Friendship does not exist.";
        }
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        error_log("Error removing friend: " . $e->getMessage());
        // Display a generic error message to the user
        echo "An error occurred while processing your request. Please try again later.";
    }
} else {
    // Invalid or missing friend ID, exit gracefully
    exit;
}
?>