<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="javascript/databaseRequest.js"></script>
    <title>Travel Together - Create Account</title>
    <!--<style>
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
    </form>-->




    <link href="https://fonts.googleapis.com/css2?family=Mansalva&display=swap" rel="stylesheet">

    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    header {
        padding: 20px;
        background-color: #fff;
    }
    header h1 {
        margin-left: 30px;
        color: #000000;
        font-family: "Mansalva", sans-serif;
        font-weight: 400;
        font-style: normal;
        text-align: left;
    }
    main {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #f8f9fa;
    }
    .form-container {
        background-color: #fff;
        padding: 20px;
        margin-top: 10px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 0px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 500px;
    }
    .form-container h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    form {
        display: flex;
        flex-direction: column;
    }
    tr {
        text-align: right;
    }
    .lala {
        text-align: left;
        height: 45px;
    }
    label {
        margin-bottom: 5px;
        font-size: 14px;
    }
    input {
        margin-bottom: 10px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 20px;
        font-size: 14px;
    }
    select {
        margin-bottom: 10px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 20px;
        font-size: 14px;
    }
    p{
        text-align: center;
        margin-top: 10px;
        font-size: 16px;
        font-family: "Mansalva", sans-serif;
        font-weight: 400;
        font-style: normal;
    }
    p a {
        color: #007bff;
        font-family: "Mansalva", sans-serif;
        font-weight: 400;
        font-style: normal;
        /*text-decoration: none;*/
    }
    p a:hover {
        text-decoration: underline;
    }
    footer {
        background-color: #003366;
        height: 30px;
    }

    input[type="submit"] {
        width: 110px;
        padding: 10px;
        margin: auto;
        border: 1px solid #ccc;
        border-radius: 20px;
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
        <h1>Explore <br> Together</h1>
    </header>
    <main>
        <div class="form-container">
            <h2>Create your account</h2>
            <form id="registrationForm">
                <table>
                    <tr>
                        <td><label for="full-name">Your full name:</label></td>
                        <td class="lala"><input type="text" id="username" name="username" required></td>
                    <tr>
                        <td><label for="gender">Your gender:</label></td>
                        <td class="lala"><select id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                                <option value="O">Other</option>
                            </select><br></td>
                    </tr>
                    <tr>
                        <td><label for="birthday">Your birthday:</label></td>
                        <td class="lala"><input type="date" id="birthdate" name="birthdate" required></td>
                    </tr>
                    <tr>
                        <td><label for="password">Password:</label></td>
                        <td class="lala"><input type="password" id="password" name="password" required></td>
                    </tr>
                </table>

                <input type="submit" value="Start to Surf">
            </form>
            <p>Already have an account ?<br>
            <a href="login.php">Log in</a></p>
        </div>
    </main>
    <footer></footer>




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