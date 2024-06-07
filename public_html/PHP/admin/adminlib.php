<?php
function isAdmin(int $userID, PDO $pdo): bool {
    try {
        // Prepare the SQL statement to check if the user is an admin
        $stmt = $pdo->prepare("SELECT isAdmin FROM users WHERE ID = :userID");
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if a result is returned and if the user is an admin
        if ($result) {
            return (bool)$result['isAdmin'];
        }
    } catch (Exception $e) {
        // Optionally log the exception $e->getMessage()
        return false;
    }

    return false;
}
?>