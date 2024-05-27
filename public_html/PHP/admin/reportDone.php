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

// Check if reportID and isDone are provided in the request and are valid
if (isset($_POST['reportID']) && is_numeric($_POST['reportID']) && isset($_POST['isDone']) && ($_POST['isDone'] == '0' || $_POST['isDone'] == '1')) {
    // Get the report ID from the request (assuming it's an integer)
    $reportID = (int)$_POST['reportID'];
    // Get the isDone state from the request (assuming it's an integer 0 or 1)
    $isDone = (int)$_POST['isDone'];

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

        // Prepare SQL statement to update the report state
        $stmt = $conn->prepare("UPDATE reports SET isDone = :isDone WHERE reportID = :reportID");
        $stmt->bindParam(':reportID', $reportID, PDO::PARAM_INT);
        $stmt->bindParam(':isDone', $isDone, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any row was affected (report was updated)
        if ($stmt->rowCount() > 0) {
            // Respond with success
            http_response_code(200); // OK
            echo json_encode(array("success" => true, "status_text" => "Report state updated.", 'status_code' => 200));
        } else {
            // Respond with not found if no rows were affected
            http_response_code(404); // Not Found
            echo json_encode(array("success" => false, "status_text" => "Report not found or state unchanged.", 'status_code' => 404));
        }
        exit;
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        error_log("Error updating report: " . $e->getMessage());
        // Return a generic error message
        http_response_code(500); // Internal Server Error
        echo json_encode(array("success" => false, "status_text" => "An error occurred while processing your request. Please try again later.", 'status_code' => 500));
        exit;
    }
} else {
    // Invalid or missing report ID or isDone parameter, exit gracefully
    http_response_code(400); // Bad Request
    echo json_encode(array('success' => false, 'status_text' => "Invalid or missing report ID or isDone parameter", 'status_code' => 400));
    exit;
}
?>