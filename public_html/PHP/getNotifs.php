<?php
// Start the session
session_start();

// Initialize response array
$response = array();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Set error response
    $response['success'] = false;
    $response['message'] = "User not logged in";
    // Return JSON response with 401 status code (Unauthorized)
    http_response_code(401);
    echo json_encode($response);
    exit;
}

// Database connection parameters
include 'databaseConnection.php';

try {
    // Create a PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve notifications for the logged-in user
    $stmt = $conn->prepare("SELECT * FROM notifs WHERE userID = :user_id ORDER BY notifID DESC");
    $stmt->bindParam(':user_id', $_SESSION['userID'], PDO::PARAM_INT); 
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Set success response
    $response['success'] = true;
    // Set notifications in the response
    $response['notifications'] = $notifications;
    // Set success message
    $response['message'] = "Notifications retrieved successfully.";

    // Return JSON response with 200 status code (OK)
    http_response_code(200);
    echo json_encode($response);
    exit;

} catch(PDOException $e) {
    // Set error response
    $response['success'] = false;
    $response['message'] = "Error: " . $e->getMessage();
    // Return JSON response with 500 status code (Internal Server Error)
    http_response_code(500);
    echo json_encode($response);
    exit;
}
?>