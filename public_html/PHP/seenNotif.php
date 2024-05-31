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

    // Get data from POST request
    if (isset($_POST['notifID'])) {
        // Validate notifID
        $notifID = filter_var($_POST['notifID'], FILTER_VALIDATE_INT);
        if ($notifID === false) {
            throw new Exception("Invalid notification ID.");
        }

        // User ID is the logged-in user
        $userID = $_SESSION['userID'];

        // SQL query to update the notification as seen
        $sql = "UPDATE notifs SET isSeen = 1 WHERE notifID = :notifID AND userID = :userID";

        // Prepare statement
        $stmt = $conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':notifID', $notifID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        // Execute statement
        $stmt->execute();

        // Check if any row was updated
        if ($stmt->rowCount() > 0) {
            // Set success response
            $response['success'] = true;
            $response['message'] = "Notification marked as seen successfully.";
            // Return JSON response with 200 status code (OK)
            http_response_code(200);
        } else {
            // Set error response
            $response['success'] = false;
            $response['message'] = "Notification not found or not owned by user.";
            // Return JSON response with 404 status code (Not Found)
            http_response_code(404);
        }
        echo json_encode($response);
        exit;
    } else {
        // Set error response
        $response['success'] = false;
        $response['message'] = "Notification ID not provided";
        // Return JSON response with 400 status code (Bad Request)
        http_response_code(400);
        echo json_encode($response);
        exit;
    }
} catch(Exception $e) {
    // Set error response
    $response['success'] = false;
    $response['message'] = "Error: " . $e->getMessage();
    // Return JSON response with 500 status code (Internal Server Error)
    http_response_code(500);
    echo json_encode($response);
    exit;
}
?>