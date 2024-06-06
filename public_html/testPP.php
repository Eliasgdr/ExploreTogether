<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Image Upload and Display</title>
</head>
<body>
    <h1>Upload Profile Image</h1>
    <form action="php/uploadImage.php" method="post" enctype="multipart/form-data">
        <label for="profileImage">Choose Image:</label>
        <input type="file" id="profileImage" name="profileImage" accept="image/*" required><br><br>
        <input type="submit" name="submit" value="Upload Image">
    </form>

    <h1>Display Profile Image</h1>
    <img src="php/displayImage.php" alt="Profile Image">
    <?php echo time(); ?>
</body>
</html>
