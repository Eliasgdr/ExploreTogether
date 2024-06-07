<?php
// Database connection parameters
include '../databaseConnection.php';
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

// Check if reportID is provided in the request and is numeric
if (isset($_POST['reportID']) && is_numeric($_POST['reportID'])) {
    // Get the report ID from the request (assuming it's an integer)
    $reportID = (int)$_POST['reportID'];

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT isAdmin FROM users WHERE ID = :userID");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the user is an admin
        if (!(bool)$result['isAdmin']) {
            http_response_code(401); // Unauthorized
            echo json_encode(array('success' => false, 'status_text' => "User is not an Admin" . $result['isAdmin'], 'status_code' => 401));
            exit;
        }

        // Prepare SQL statement to delete the report
        $stmt = $conn->prepare("DELETE FROM reports WHERE reportID = :reportID");
        $stmt->bindParam(':reportID', $reportID, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any row was affected (report was deleted)
        if ($stmt->rowCount() > 0) {
            // Respond with success
            http_response_code(200); // OK
            echo json_encode(array("success" => true, "status_text" => "Report deleted successfully.", 'status_code' => 200));
        } else {
            // Respond with not found if no rows were affected
            http_response_code(404); // Not Found
            echo json_encode(array("success" => false, "status_text" => "Report not found.", 'status_code' => 404));
        }
        exit;
    } catch (PDOException $e) {
        // Log the error for debugging purposes
        error_log("Error deleting report: " . $e->getMessage());
        // Return a generic error message
        http_response_code(500); // Internal Server Error
        echo json_encode(array("success" => false, "status_text" => "An error occurred while processing your request. Please try again later." .  $e->getMessage(), 'status_code' => 500));
        exit;
    }
} else {
    // Invalid or missing report ID, exit gracefully
    http_response_code(400); // Bad Request
    echo json_encode(array('success' => false, 'status_text' => "Invalid or missing report ID", 'status_code' => 400));
    exit;
}
?>