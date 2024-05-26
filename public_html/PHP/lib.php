<?php
function bool isAdmin(userID, pdo) {
    try {
        // Check if the user has admin access
        $stmt = $pdo->prepare("SELECT isAdmin FROM users WHERE userID = :userID");
        $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return (bool)$result['isAdmin'];
        }
    } catch () {
        return 0;
    }

}
?>