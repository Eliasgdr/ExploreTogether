<?php
// Database connection parameters
include 'databaseConnection.php';

$response = array();

// Create a PDO connection
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Return JSON response on connection failure
    http_response_code(500);
    echo json_encode(array('success' => false, 'status_text' => "Connection failed: " . $e->getMessage(), 'status_code' => 500));
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are provided
    if (isset($_POST["name"]) && isset($_POST["gender"]) && isset($_POST["birthdate"]) && isset($_POST["password"]) && isset($_POST["email"])) {
        // Retrieve user data from the form
        $name = $_POST["name"];
        $gender = $_POST["gender"];
        $birthdate = $_POST["birthdate"];
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Check if the username is already in use
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $existingUser = $stmt->fetch();

        /*if ($existingUser) {
            // Return JSON response for username already in use
            http_response_code(400);
            echo json_encode(array('success' => false, 'status_text' => "Username already in use.", 'status_code' => 400));
            exit;
        }*/

        // Continue with user registration
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Prepare a SQL query to insert user into the database
            $stmt = $conn->prepare("INSERT INTO users (username, gender, birthdate, password, email) VALUES (:name, :gender, :birthdate, :password, :email)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':birthdate', $birthdate);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();

            // Return JSON response for successful registration
            http_response_code(200);
            echo json_encode(array('success' => true, 'message' => "User registered successfully."));
            exit;
        } catch(PDOException $e) {
            // Return JSON response on database error
            http_response_code(500);
            echo json_encode(array('success' => false, 'status_text' => "Error: " . $e->getMessage(), 'status_code' => 500));
            exit;
        }
    } else {
        // Return JSON response for missing fields
        http_response_code(400);
        echo json_encode(array('success' => false, 'status_text' => "All fields are required.", 'status_code' => 400));
        exit;
    }
}

// Close database connection
$conn = null;
?>