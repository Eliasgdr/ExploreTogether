<?php
// Database connection parameters
include 'databaseConnection.php';

// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    // Return unauthorized response if not logged in
    http_response_code(401); // Unauthorized
    echo json_encode(array('success' => false, 'status_text' => "User not logged in", 'status_code' => 401));
    exit;
}

// Check if user ID is provided in the request and is numeric
if (isset($_GET['userID']) && is_numeric($_GET['userID'])) {
    // Get the user ID from the request (assuming it's an integer)
    $userID = (int)$_GET['userID'];

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to retrieve the public info of the user
        $stmt = $conn->prepare("SELECT ID, username, description, profileImage FROM users WHERE ID = :userID");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the user info
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Prepare the response data
            $response = array(
                "success" => true,
                "status_code" => 200,
                "data" => array(
                    "id" => $user['ID'],
                    "name" => $user['username'],
                    "description" => $user['description'],
                    "profileImage" => base64_encode($user['profileImage'])
                )
            );
            // Return the user info as JSON
            http_response_code(200); // OK
            echo json_encode($response);
            exit;
        } else {
            // User not found
            http_response_code(404); // Not Found
            echo json_encode(array("success" => false, "status_text" => "User not found.", 'status_code' => 404));
            exit;
        }
    } catch (PDOException $e) {
        // Return a generic error message
        http_response_code(500); // Internal Server Error
        echo json_encode(array("success" => false, "status_text" => "An error occurred while processing your request. Please try again later.", 'status_code' => 500));
        exit;
    }
} else {
    // Invalid or missing user ID, exit gracefully
    http_response_code(400); // Bad Request
    echo json_encode(array('success' => false, 'status_text' => "Invalid or missing user ID", 'status_code' => 400));
    exit;
}
?>