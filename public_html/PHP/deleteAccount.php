<?php

// Database connection parameters
include 'databaseConnection.php';

session_start();

// Initialize response array
$response = array();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    http_response_code(401);
    $response['success'] = false;
    $response['status_text'] = "User not logged in";
    $response['status_code'] = 401;
    echo json_encode($response);
    exit;
}

// Check if password is provided
if (!isset($_POST['password'])) {
    http_response_code(400);
    $response['success'] = false;
    $response['status_text'] = "Password not provided";
    $response['status_code'] = 400;
    echo json_encode($response);
    exit;
}

try {
    // Create connection
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the user ID from the session
    $userID = $_SESSION['userID'];
    $providedPassword = $_POST['password'];

    // SQL query to get the user's stored password hash
    $sql = "SELECT password FROM users WHERE ID = :userID";

    // Prepare statement
    $stmt = $pdo->prepare($sql);

    // Bind parameter
    $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

    // Execute statement
    $stmt->execute();

    // Fetch the stored password hash
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($providedPassword, $user['password'])) {
        // Password is correct, proceed to delete the account
        $sql = "DELETE FROM users WHERE ID = :userID";

        // Prepare statement
        $stmt = $pdo->prepare($sql);

        // Bind parameter
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        // Execute statement
        $stmt->execute();

        // Check if the account was deleted
        if ($stmt->rowCount() > 0) {
            // Account deleted successfully, destroy session
            session_destroy();
            $response['success'] = true;
            $response['message'] = "Account deleted successfully";
            echo json_encode($response);
        } else {
            // Account not found or already deleted
            http_response_code(404);
            $response['success'] = false;
            $response['status_text'] = "Account not found";
            $response['status_code'] = 404;
            echo json_encode($response);
        }
    } else {
        // Password is incorrect
        http_response_code(403);
        $response['success'] = false;
        $response['status_text'] = "Incorrect password";
        $response['status_code'] = 403;
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