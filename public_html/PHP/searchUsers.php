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

// Check if search query is provided in the request
if (isset($_GET['query'])) {
    // Get the search query from the request parameters
    $searchQuery = $_GET['query'];
    $userID = (int)$_SESSION['userID'];

    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare the SQL statement to search for users
        $stmt = $conn->prepare("
            SELECT ID, username, description, profileImage
            FROM users
            WHERE username LIKE :query
              AND ID != :userID
              AND ID NOT IN (
                  SELECT blockedUserID FROM blockedusers WHERE userID = :userID
              )
              AND ID NOT IN (
                  SELECT userID FROM blockedusers WHERE blockedUserID = :userID
              )
        ");
        $stmt->bindValue(':query', "%$searchQuery%", PDO::PARAM_STR);
        $stmt->bindValue(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the search results
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Prepare the response data
        $response = array(
            "success" => true,
            "status_code" => 200,
            "data" => array()
        );

        foreach ($users as $user) {
            $response['data'][] = array(
                "ID" => $user['ID'],
                "username" => $user['username'],
                "description" => $user['description'],
                "profileImage" => base64_encode($user['profileImage'])
            );
        }

        // Return the search results in JSON format
        http_response_code(200); // OK
        echo json_encode($response);
        exit;

    } catch (PDOException $e) {
        // Log the error for debugging purposes
        //console.log("Error searching users: " . $e->getMessage());
        // Return a generic error message
        http_response_code(500); // Internal Server Error
        echo json_encode(array("success" => false, "status_text" => "An error occurred while processing your request. Please try again later. " . $e->getMessage(), 'status_code' => 500));
        exit;
    }
} else {
    // Invalid or missing search query, exit gracefully
    http_response_code(400); // Bad Request
    echo json_encode(array('success' => false, 'status_text' => "Invalid or missing search query", 'status_code' => 400));
    exit;
}
?>