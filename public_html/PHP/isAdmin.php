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

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the user has admin access
    $stmt = $conn->prepare("SELECT isAdmin FROM users WHERE userID = :userID");
    $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $response['success'] = true;
        $response['isAdmin'] = (bool)$result['isAdmin']; // Cast to boolean
        $response['message'] = "success";
    } else {
        $response['success'] = false;
        $response['message'] = "User not found";
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