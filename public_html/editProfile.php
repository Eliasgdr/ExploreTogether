<?php
include 'php/databaseConnection.php';

if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect($servername, $username, $password, $dbname);

include('php/uploadImage.php');

// Fetch current user data
$user_id = $_SESSION['userID'];
$sql = "SELECT username, gender, birthdate, description, email, profileImage FROM users WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $gender, $birthdate, $description, $email, $profileImage);
$stmt->fetch();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $_POST['username'];
    $new_gender = $_POST['gender'];
    $new_birthdate = $_POST['birthdate'];
    $new_description = $_POST['description'];
    $new_email = $_POST['email'];

    // Handle image upload
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['profileImage']['tmp_name'];
        $image = file_get_contents($image);
        $image = base64_encode($image);

        $update_sql = "UPDATE users SET username = ?, gender = ?, birthdate = ?, description = ?, email = ?, profileImage = ? WHERE ID = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssssssi", $new_username, $new_gender, $new_birthdate, $new_description, $new_email, $image, $user_id);
    } else {
        $update_sql = "UPDATE users SET username = ?, gender = ?, birthdate = ?, description = ?, email = ? WHERE ID = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssssi", $new_username, $new_gender, $new_birthdate, $new_description, $new_email, $user_id);
    }

    if ($update_stmt->execute()) {
        // Refresh user data after update
        $username = $new_username;
        $gender = $new_gender;
        $birthdate = $new_birthdate;
        $description = $new_description;
        $email = $new_email;

        // Redirect to profile page
        header("Location: profile.php?userID=" . $user_id);
        exit();
    } else {
        $error_message = "Error updating profile: " . $conn->error;
    }

    $update_stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link href="./stylessheet/editprofile.css?<?php echo time(); ?>" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <div class="title" onclick="window.location.href='welcome.php'">Explore Together</div>
        <div class="redirect">
            <a type="button" class="titleButton" onclick="redirectMessages()">Messages</a>
            <?php echo '<a type="button" class="titleButton" onclick="window.location.href=\'profile.php?userID=' . $user_id . '\'">Profile</a>'; ?>
        </div>
    </header>

    <div class="container">

        <h1>Edit Profile</h1>
        <?php if (isset($error_message)) echo "<p>$error_message</p>"; ?>

        
        <?php if ($profileImage) { ?>
        <img id='imgPreview' src="data:image/jpeg;base64,<?php echo $profileImage; ?>" alt="Profile Image">
    <?php } else { ?>
        <img src="default-profile.png" alt="Default Profile Image">
    <?php } ?>
        <form id="profileForm" method="POST" enctype="multipart/form-data" action="editProfile.php" class='formContainer'>
            <label for="profileImage">Choose Image:</label>
            <input type="file" id="profileImage" name="profileImage" accept="image/*"><br><br>

            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br><br>

            <label for="gender">Gender:</label><br>
            <select id="gender" name="gender" required>
                <option value="M" <?php if ($gender === 'M') echo 'selected'; ?>>Male</option>
                <option value="F" <?php if ($gender === 'F') echo 'selected'; ?>>Female</option>
                <option value="O" <?php if ($gender === 'O') echo 'selected'; ?>>Other</option>
            </select><br><br>

            <label for="birthdate">Birthdate:</label><br>
            <input type="date" id="birthdate" name="birthdate" value="<?php echo htmlspecialchars($birthdate); ?>" required><br><br>

            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="8" cols="50" required><?php echo htmlspecialchars($description); ?></textarea><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

            <input type="submit" value="Update Profile">
        </form>
    </div>

    <footer>
        <h5>&copy; 2024 Travel Together | All Rights Reserved<br></h5>
    </footer>
</body>
</html>
