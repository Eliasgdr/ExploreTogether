<?php
session_start();
// Database connection parameters
include 'databaseConnection.php';

// Create a PDO connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(array('success' => false, 'status_text' => "Connection failed: " . $e->getMessage(), 'status_code' => 500));
    exit;
}

$response = array(); // Initialize an empty array for the response

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if username and password are provided
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        // Retrieve username and password from the form
        $username = $_POST["username"];
        $password = $_POST["password"];

        try {
            // Prepare a SQL query to retrieve user from the database
            $stmt = $conn->prepare("SELECT ID, password FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            $user = $stmt->fetch();

            if ($user) {
                // Verify the password
                if (password_verify($password, $user['password'])) {
                    // Password is correct, set the session variable
                    $_SESSION["userID"] = $user['ID'];
                    // Add success message to the response
                    http_response_code(200);
                    echo json_encode(array('success' => true, 'status_text' => "Login successful", 'status_code' => 200));
                    exit;
                } else {
                    // Password is incorrect
                    http_response_code(401);
                    echo json_encode(array('success' => false, 'status_text' => "Incorrect password", 'status_code' => 401));
                    exit;
                }
            } else {
                // User not found
                http_response_code(404);
                echo json_encode(array('success' => false, 'status_text' => "User not found", 'status_code' => 404));
                exit;
            }
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode(array('success' => false, 'status_text' => "Error: " . $e->getMessage(), 'status_code' => 500));
            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode(array('success' => false, 'status_text' => "Error: Username or password not provided", 'status_code' => 400));
        exit;
    }
} else {
    http_response_code(405);
    echo json_encode(array('success' => false, 'status_text' => "Error: Invalid request method", 'status_code' => 405));
    exit;
}
?>