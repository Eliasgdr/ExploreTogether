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

// Check if userID is provided in the request
if (isset($_POST['userID']) && is_numeric($_POST['userID'])) {
    // Get the userID from the request
    $userID = $_POST['userID'];

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to retrieve countries visited by the user
        $stmt = $conn->prepare("SELECT * FROM countries WHERE id IN (SELECT countryID FROM userVisitedCountries WHERE userID = :userID)");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the visited countries
        $visitedCountries = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the visited countries as JSON
        http_response_code(200); // OK
        echo json_encode($visitedCountries);
        exit;
    } catch (PDOException $e) {
        // Return a generic error message
        http_response_code(500); // Internal Server Error
        echo json_encode(array('success' => false, 'status_text' => "An error occurred while processing your request. Please try again later. ". $e->getMessage() , 'status_code' => 500));
        exit;
    }
} else {
    // Invalid or missing userID, return error response
    http_response_code(400); // Bad Request
    echo json_encode(array('success' => false, 'status_text' => "Invalid or missing userID", 'status_code' => 400));
    exit;
}
?>