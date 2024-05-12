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
    die("Connection failed: " . $e->getMessage());
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
                    $response = array('success' => true, 'message' => "Login successful");
                } else {
                    // Password is incorrect
                    $response = array('success' => false, 'message' => "Incorrect password");
                }
            } else {
                // User not found
                $response = array('success' => false, 'message' => "User not found");
            }
        } catch(PDOException $e) {
            $response = array('success' => false, 'message' => "Error: " . $e->getMessage());
        }
    } else {
        $response = array('success' => false, 'message' => "Error: Username or password not provided");
    }
} else {
    $response = array('success' => false, 'message' => "Error: Invalid request method");
}

// Close database connection
$conn = null;

// Send JSON response back to the client
header('Content-Type: application/json');
echo json_encode($response);
?>