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

// Check if userID and countryIDs are provided in the request
if (isset($_POST['userID']) && is_numeric($_POST['userID']) && isset($_POST['countryIDs'])) {
    // Get the userID from the request
    $userID = $_POST['userID'];
    // Extract countryIDs from the request
    $countryIDs = $_POST['countryIDs'];

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Delete existing entries for this user in userVisitedCountries table
        $stmt = $conn->prepare("DELETE FROM userVisitedCountries WHERE userID = :userID");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        // Prepare SQL statement to insert new entries into userVisitedCountries table
        $stmt = $conn->prepare("INSERT INTO userVisitedCountries (userID, countryID) VALUES (:userID, :countryID)");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);

        // Loop through each countryID and insert into userVisitedCountries table
        foreach ($countryIDs as $countryID) {
            $stmt->bindParam(':countryID', $countryID, PDO::PARAM_INT);
            $stmt->execute();
        }

        // Return success response
        http_response_code(200); // OK
        echo json_encode(array('success' => true, 'status_text' => "Visited countries updated successfully.", 'status_code' => 200));
        exit;
    } catch (PDOException $e) {
        // Return a generic error message
        http_response_code(500); // Internal Server Error
        echo json_encode(array('success' => false, 'status_text' => "An error occurred while processing your request. Please try again later.", 'status_code' => 500));
        exit;
    }
} else {
    // Invalid or missing userID or countryIDs, return error response
    http_response_code(400); // Bad Request
    echo json_encode(array('success' => false, 'status_text' => "Invalid or missing userID or countryIDs", 'status_code' => 400));
    exit;
}
?>