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
    $response['success'] = false;
    $response['message'] = "Connection failed: " . $e->getMessage();
    echo json_encode($response);
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are provided
    if (isset($_POST["name"]) && isset($_POST["gender"]) && isset($_POST["birthdate"]) && isset($_POST["password"])) {
        // Retrieve user data from the form
        $name = $_POST["name"];
        $gender = $_POST["gender"];
        $birthdate = $_POST["birthdate"];
        $password = $_POST["password"];

        // Check if the username is already in use
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            // Return JSON response for username already in use
            $response = array("success" => false, "message" => "Username already in use.");
            echo json_encode($response);
            exit;
        }

        // Continue with user registration
        // Hash the password before storing it in the database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Prepare a SQL query to insert user into the database
            $stmt = $conn->prepare("INSERT INTO users (username, gender, birthdate, password) VALUES (:name, :gender, :birthdate, :password)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':birthdate', $birthdate);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->execute();

            // Return JSON response for successful registration
            $response = array("success" => true, "message" => "User registered successfully.");
            echo json_encode($response);
            exit;
        } catch(PDOException $e) {
            // Return JSON response on database error
            $response = array("success" => false, "message" => "Error: " . $e->getMessage());
            echo json_encode($response);
            exit;
        }
    } else {
        // Return JSON response for missing fields
        $response = array("success" => false, "message" => "All fields are required.");
        echo json_encode($response);
        exit;
    }
}

// Close database connection
$conn = null;
?>