<?php
// Database connection parameters
include 'databaseConnection.php';
include 'adminlib.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Redirect to login page if not logged in
    http_response_code(401); // Unauthorized
    echo json_encode(array('success' => false, 'status_text' => "User not logged in", 'status_code' => 401));
    exit;
}

// Get the user ID from the session (assuming it's an integer)
$userID = (int)$_SESSION['userID'];

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the user is an admin
    if (!isAdmin($userID, $conn)) {
        http_response_code(401); // Unauthorized
        echo json_encode(array('success' => false, 'status_text' => "User is not an Admin", 'status_code' => 401));
        exit;
    }

    // Prepare SQL statement to select reports where isDone = 0
    $stmt = $conn->prepare("SELECT * FROM reports WHERE isDone = 0");
    $stmt->execute();

    // Fetch the reports
    $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Respond with the reports data
    http_response_code(200); // OK
    echo json_encode(array("success" => true, "reports" => $reports, 'status_code' => 200));
    exit;
} catch (PDOException $e) {
    // Log the error for debugging purposes
    error_log("Error fetching reports: " . $e->getMessage());
    // Return a generic error message
    http_response_code(500); // Internal Server Error
    echo json_encode(array("success" => false, "status_text" => "An error occurred while processing your request. Please try again later.", 'status_code' => 500));
    exit;
}
?>