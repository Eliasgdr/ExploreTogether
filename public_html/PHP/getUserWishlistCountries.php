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

        // Prepare SQL statement to retrieve countries from user's wishlist
        $stmt = $conn->prepare("SELECT * FROM countries WHERE id IN (SELECT countryID FROM userWishlistCountries WHERE userID = :userID)");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the countries from the user's wishlist
        $wishlistCountries = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the wishlist countries as JSON
        http_response_code(200); // OK
        echo json_encode($wishlistCountries);
        exit;
    } catch (PDOException $e) {
        // Return a generic error message
        http_response_code(500); // Internal Server Error
        echo json_encode(array('success' => false, 'status_text' => "An error occurred while processing your request. Please try again later.", 'status_code' => 500));
        exit;
    }
} else {
    // Invalid or missing userID, return error response
    http_response_code(400); // Bad Request
    echo json_encode(array('success' => false, 'status_text' => "Invalid or missing userID", 'status_code' => 400));
    exit;
}
?>