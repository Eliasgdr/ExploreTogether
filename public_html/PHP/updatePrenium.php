<?php
// Database connection parameters
include 'databaseConnection.php';

// Start the session
session_start();

// Initialize response array
$response = array();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    $response['success'] = false;
    $response['message'] = "User not logged in";
    http_response_code(401); // Unauthorized status code
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Validate and sanitize input
$isPrenium = $_POST['isPrenium']; // Corrected variable name

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update the user's prenium status
    $stmt = $conn->prepare("UPDATE users SET isPrenium = :isPrenium WHERE ID = :userID");
    $stmt->bindParam(':isPrenium', $isPrenium, PDO::PARAM_BOOL);
    $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);
    $stmt->execute();

    // Check if any rows were affected by the update
    if ($stmt->rowCount() > 0) {
        $response['success'] = true;
        $response['message'] = "User prenium status updated successfully";
    } else {
        $response['success'] = false;
        $response['message'] = "User not found or already has the same prenium status";
        http_response_code(404); // Not Found status code
    }

    // Return JSON response with appropriate status code
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    // Handle database connection errors
    $response['success'] = false;
    $response['message'] = "An error occurred while processing your request: " . $e->getMessage();
    http_response_code(500); // Internal server error status code
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>