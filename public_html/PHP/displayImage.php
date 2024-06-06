<?php
include 'databaseConnection.php';

session_start();

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Get the userID of the logged-in user
$userID = $_SESSION['userID'];

// Retrieve the profile image data for the logged-in user
$sql = "SELECT profileImage FROM users WHERE ID = '$userID'";
$result = mysqli_query($conn, $sql);

if ($result) {
    // Fetch the profile image data
    $row = mysqli_fetch_assoc($result);
    $imageData = $row['profileImage'];

    // Check if image data exists
    if ($imageData) {
        // Set the appropriate content-type header
        header('Content-type: image/jpeg');
        // Output the image data
        echo base64_decode($imageData);
        exit(); // Exit after outputting the image data
    } else {
        // If no image data found, display a default image or an error message
        echo "No profile image found.";
    }
} else {
    // If SQL query fails, display an error message
    echo "Error fetching profile image.";
}
?>
