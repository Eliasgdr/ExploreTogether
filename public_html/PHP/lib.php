<?php

function isEmailBanned($email, $conn) {
    try {
        // Prepare SQL statement to check if the email is banned
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM bannedemail WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the count is greater than 0, meaning the email is banned
        if ($result['count'] > 0) {
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        error_log("Error checking if email is banned: " . $e->getMessage());
        return false; // Return false on error
    }
}
?>