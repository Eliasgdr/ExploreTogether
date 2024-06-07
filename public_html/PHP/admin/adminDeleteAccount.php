<?php

// Database connection parameters
include '../databaseConnection.php';
include 'adminlib.php';

session_start();

// Initialize response array
$response = array();

// Check if the admin is logged in
if (!isset($_SESSION['userID'])) {
    http_response_code(401);
    $response['success'] = false;
    $response['status_text'] = "Admin not logged in";
    $response['status_code'] = 401;
    echo json_encode($response);
    exit;
}

// Check if user ID to delete is provided
if (!isset($_POST['userIDToDelete'])) {
    http_response_code(400);
    $response['success'] = false;
    $response['status_text'] = "User ID to delete not provided";
    $response['status_code'] = 400;
    echo json_encode($response);
    exit;
}

try {
    // Create connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the admin ID from the session
    $adminID = $_SESSION['userID'];
    $userIDToDelete = $_POST['userIDToDelete'];

    // Check if the logged-in user is an admin
    if (!isAdmin($adminID, $pdo)) {
        http_response_code(403);
        $response['success'] = false;
        $response['status_text'] = "User is not an admin";
        $response['status_code'] = 403;
        echo json_encode($response);
        exit;
    }

    // SQL query to delete user account
    $sql = "DELETE FROM users WHERE ID = :userIDToDelete";

    // Prepare statement
    $stmt = $pdo->prepare($sql);

    // Bind parameter
    $stmt->bindParam(':userIDToDelete', $userIDToDelete, PDO::PARAM_INT);

    // Execute statement
    $stmt->execute();

    // Check if the account was deleted
    if ($stmt->rowCount() > 0) {
        // Account deleted successfully
        $response['success'] = true;
        $response['message'] = "User account deleted successfully";
        echo json_encode($response);
    } else {
        // Account not found or already deleted
        http_response_code(404);
        $response['success'] = false;
        $response['status_text'] = "User account not found";
        $response['status_code'] = 404;
        echo json_encode($response);
    }
} catch(PDOException $e) {
    http_response_code(500);
    $response['success'] = false;
    $response['status_text'] = "Error: " . $e->getMessage();
    $response['status_code'] = 500;
    echo json_encode($response);
}

// Close connection (not necessary for PDO, but good practice)
$pdo = null;
?>