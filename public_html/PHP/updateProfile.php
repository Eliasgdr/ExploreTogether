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

// Initialize variables
$username = isset($_POST['username']) ? $_POST['username'] : null;
$description = isset($_POST['description']) ? $_POST['description'] : null;
$profileImage = isset($$_POST['profileImage']) ? $$_POST['profileImage'] : null;

// Check if any data is provided in the request
if ($username !== null || $description !== null || $profileImage !== null) {
    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to update user data in the database
        $sql = "UPDATE users SET ";
        $parameters = array();x   

        if ($username !== null) {
            $sql .= "username = :username, ";
            $parameters[':username'] = $username;
        }

        if ($description !== null) {
            $sql .= "description = :description, ";
            $parameters[':description'] = $description;
        }

        if ($profileImage !== null) {
            $sql .= "profileImage = :profileImage, ";
            $parameters[':profileImage'] = $profileImage;
        }

        // Remove trailing comma and space
        $sql = rtrim($sql, ', ');

        // Add condition for the specific user (assuming you have a user ID)
        $sql .= " WHERE ID = :userID";

        // Add user ID parameter
        $parameters[':userID'] = $_SESSION['userID'];

        // Prepare and execute the SQL statement
        $stmt = $conn->prepare($sql);
        $stmt->execute($parameters);

        // Return success response
        http_response_code(200); // OK
        echo json_encode(array('success' => true, 'status_text' => "User data updated successfully.", 'status_code' => 200));
        exit;
    } catch (PDOException $e) {
        // Return a generic error message
        http_response_code(500); // Internal Server Error
        echo json_encode(array('success' => false, 'status_text' => "An error occurred while processing your request. Please try again later.", 'status_code' => 500));
        exit;
    }
} else {
    // No data provided, return success response (since no changes were made)
    http_response_code(200); // OK
    echo json_encode(array('success' => true, 'status_text' => "No data provided.", 'status_code' => 200));
    exit;
}
?>