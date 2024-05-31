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

// Check if email is provided in the request
if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    // Get the email from the request
    $email = $_POST['email'];

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

        // Prepare SQL statement to insert the banned email
        $stmt = $conn->prepare("INSERT INTO bannedemail (email) VALUES (:email)");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // Respond with success
        http_response_code(200); // OK
        echo json_encode(array("success" => true, "status_text" => "Email banned.", 'status_code' => 200));
        exit;
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        error_log("Error banning email: " . $e->getMessage());
        // Return a generic error message
        http_response_code(500); // Internal Server Error
        echo json_encode(array("success" => false, "status_text" => "An error occurred while processing your request. Please try again later.", 'status_code' => 500));
        exit;
    }
} else {
    // Invalid or missing email, exit gracefully
    http_response_code(400); // Bad Request
    echo json_encode(array('success' => false, 'status_text' => "Invalid or missing email", 'status_code' => 400));
    exit;
}
?>