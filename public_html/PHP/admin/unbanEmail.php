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

// Check if email ID is provided in the request
if (isset($_POST['emailID']) && ctype_digit($_POST['emailID'])) {
    // Get the email ID from the request
    $emailID = (int)$_POST['emailID'];

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

        // Prepare SQL statement to delete the banned email based on email ID
        $stmt = $conn->prepare("DELETE FROM bannedemail WHERE emailID = :emailID");
        $stmt->bindParam(':emailID', $emailID, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any row was affected (email was unbanned)
        if ($stmt->rowCount() > 0) {
            // Respond with success
            http_response_code(200); // OK
            echo json_encode(array("success" => true, "status_text" => "Email unbanned.", 'status_code' => 200));
        } else {
            // Respond with not found if no rows were affected
            http_response_code(404); // Not Found
            echo json_encode(array("success" => false, "status_text" => "Email ID not found in the banned list.", 'status_code' => 404));
        }
        exit;
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        error_log("Error unbanning email: " . $e->getMessage());
        // Return a generic error message
        http_response_code(500); // Internal Server Error
        echo json_encode(array("success" => false, "status_text" => "An error occurred while processing your request. Please try again later.", 'status_code' => 500));
        exit;
    }
} else {
    // Invalid or missing email ID, exit gracefully
    http_response_code(400); // Bad Request
    echo json_encode(array('success' => false, 'status_text' => "Invalid or missing email ID", 'status_code' => 400));
    exit;
}
?>