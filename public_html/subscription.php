<?php
    session_start();
    //print_r($_SESSION);

    // Check if the user is logged in
    if (!isset($_SESSION['userID'])) {
        header("Location: login.php"); // Redirect to login page if not logged in
        exit;
    }
$user_id = $_SESSION['userID'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Together</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="javascript/databaseRequest.js?<?php echo time(); ?>"></script>
    <link href="./stylessheet/subscription.css?<?php echo time(); ?>" rel="stylesheet" type="text/css">
</head>
<body>
<header> 
    <div class="title" onclick="window.location.href='welcome.php'">Explore Together</div>
        <div class="redirect">
            <a type="button" class="titleButton"  onclick="window.location.href='messages.php'">Messages</a>
            <?php echo '<a type="button" class="titleButton" onclick="window.location.href=\'profile.php?userID=' . $user_id . '\'">Profile</a>'; ?>
        </div>
    </header>
    <div class="container">
        <div class='plan' id="premium" onclick="updatePrenium(1)">
            <h1>Premium plan</h1>
            <img src=".\images\fleurs.png">
            <p>You can access to message and add friends, follow threads and thread creation.</p>
            <h2>Only for 5€/month</h2>
        </div>
        <div class='plan' id="obsever" onclick="updatePrenium(0)">
            <h1>Obsever plan</h1>
            <img src=".\images\pelle.png">
            <p>You can just see public threads.</p>
            <h2>Only for 0€/month</h2>
        </div>
    </div>
    <footer>
        &copy; 2024 Travel Together | All Rights Reserved
    </footer>
</body>
