<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="javascript/databaseRequest.js"></script>
    <title>Travel Together - Create Account</title>
    <link href="./stylessheet/registration.css" rel="stylesheet" type="text/css">
    
    <link href="https://fonts.googleapis.com/css2?family=Mansalva&display=swap" rel="stylesheet">

</head>
<body>
    <header>
        <div class="title">Explore Together</div>
        <div class="redirect">
            <a type="button" class="titleButton" href="login.php">Sign in</a>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h2>Create your account</h2>
            <form id="registrationForm">
                <table>
                    <tr>
                        <td><label for="full-name">Your full name :</label></td>
                        <td class="lala"><input type="text" id="username" name="username" required></td>
                    <tr>
                        <td><label for="gender">Your gender :</label></td>
                        <td class="lala"><select id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Other</option>
                            </select><br></td>
                    </tr>
                    <tr>
                        <td><label for="birthday">Your birthday :</label></td>
                        <td class="lala"><input type="date" id="birthdate" name="birthdate" required></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password :</label></td>
                        <td class="lala"><input type="password" id="password" name="password" required></td>
                    </tr>
                </table>

                <input type="submit" value="Start to Surf">
            </form>
            <p>Already have an account ?<br>
            <a href="login.php">Log in</a></p>
        </div>
    </main>
    <footer>
        &copy; 2024 Travel Together | All Rights Reserved<br>
    </footer>




    <script>
    
        function registrationSuccessCallback(response) {
            if (response.success) {
                window.location.href = 'login.php';
            } else {
                alert(response.message); // Display error message
            }
        }

        function registrationErrorCallback(xhr, status, error) {
            alert('An error occurred while processing your request. Please try again later.'); // Display error message
        }
        $(document).ready(function() {
            $('#registrationForm').submit(function(e) {
                e.preventDefault(); // Prevent default form submission
        
                // Serialize form data
                var username = $("#username").val();
                var password = $("#password").val();
                var birthdate = $("#birthdate").val();
                var gender = $("#gender").val();
                console.log(username);
        
                // Send AJAX request
                registration(username, password, birthdate, gender, registrationSuccessCallback, registrationErrorCallback);
            });
        });
    </script>
</body>
</html>