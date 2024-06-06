<?php
include 'databaseConnection.php';

// Start the session
session_start();

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Redirect to login page if not logged in
    http_response_code(401); // Unauthorized
    echo json_encode(array('success' => false, 'status_text' => "User not logged in", 'status_code' => 401));
    exit;
}

// Check if the form is submitted
if(isset($_POST['submit'])) {
    $userID = $_SESSION['userID']; // Get the userID of the logged-in user
    $image = $_FILES['profileImage']['tmp_name'];
    $image = file_get_contents($image);
    $image = base64_encode($image);

    $sql = "UPDATE users SET profileImage = '$image' WHERE ID = '$userID'";
    mysqli_query($conn, $sql);

    // Redirect back to the frontend page
    header("Location: ../testPP.php");
    exit();
}
?>
