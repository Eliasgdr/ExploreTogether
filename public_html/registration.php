<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="javascript/databaseRequest.js"></script>
    <title>Travel Together - Create Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        input[type="text"],
        input[type="password"],
        select,
        input[type="date"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <header>
        <h1>Create an Account</h1>
    </header>
    <form id="registrationForm">
        <input type="text" id="username" name="username" placeholder="Full Name" required><br>
        <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
            <option value="O">Other</option>
        </select><br>
        <input type="date" id="birthdate" name="birthdate" required><br>
        <input type="password" id="password" name="password" placeholder="Password" required><br>
        <input type="submit" value="Create Account">
    </form>
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