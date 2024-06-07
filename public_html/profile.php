<?php
include 'php/databaseConnection.php';

session_start();

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Fetch user info based on user ID (you need to get the user ID somehow, perhaps through a GET parameter or session)
$userID = $_GET['userID']; // Assuming you get the user ID from the URL parameter
$query = "SELECT username, gender, birthdate, description, email, profileImage FROM users WHERE ID = $userID";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    }
    // Now, you have user information in the $user variable
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Together</title>
    <link href="./stylessheet/profile.css?<?php echo time(); ?>" rel="stylesheet" type="text/css">
</head>

<body>
    <header>
        <div class="title">Explore Together</div>
        <div class="redirect">
            <?php
            // Check if the profile being viewed is the profile of the logged-in user
        
            if ($_SESSION['userID'] == $userID) {
                echo '<a type="button" class="titleButton" onclick="window.location.href=\'editProfile.php\'">Edit Profile</a>';

            ?>
            <a type="button" class="titleButton" onclick="window.location.href='welcome.php'">Retour</a>
        </div>
    </header>
    <div class="content">
        <div class="card">
            <div class="cardPicture">
                <!-- Display profile image if available -->
                <?php if (!empty($user['profileImage'])): ?>
                    <img src="php/displayImage.php" alt="Profile Image">
                <?php endif; ?>
            </div>
            <div class="cardInfo">
                <div class="nameInfo">
                    <!-- Display username -->
                    <h3 id="name"><?php echo $user['username']; ?></h3>
                </div>
                <hr>

                <div class="subscription">
                    <h3>Exposant</h3>
                    <a type="button" class="subscriptionButton" onclick="window.location.href='subscription.php'">upgrade</a>
                </div>

                <hr>
                <div class="userInfo">
                    <!-- Display user information -->
                    <h5 id="userBirth">Birthday : <?php echo $user['birthdate']; ?></h5>
                    <div class="mainCountry">
                        <!-- Display other user info like country and email -->
                        <h4 id="country">pays</h4>
                    </div>
                    <h5 id="userEmail">E-mail : <?php echo $user['email']; ?></h5>
                    <div class="userDescript">
                        <h5>Description : </h5>
                        <p><?php echo $user['description']; ?></p>
                    </div>
                </div>
            </div>
            <div class="userMap"></div>
        </div>
    </div>
    <footer>
        <h5>&copy; 2024 Travel Together | All Rights Reserved<br></h5>
    </footer>
</body>
</html>

<?php
} else {
    // Handle the case where no user with the given ID was found
    echo "User not found.";
}
?>
