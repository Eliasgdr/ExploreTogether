<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Together</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="javascript/databaseRequest.js"></script>
    <script>
        function loginCallBackSuccess(response){
            if (response.success) {
                // Redirect to welcome.php if login is successful
                window.location.href = "welcome.php";
            } else {
                // Handle failure case (e.g., display error message)
                alert(response.message);
            }
        }
        
        function loginCallBackError(xhr, status, error){
            alert('Error');
        }
        
        $(document).ready(function(){
            $("#loginForm").submit(function(event){
                event.preventDefault();
                
                var username = $("#username").val();
                var password = $("#password").val();
                
                login(username, password, loginCallBackSuccess, loginCallBackError);
            });
        });
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mansalva&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            margin-left: 30px;
            color: #000000;
            font-family: "Mansalva", sans-serif;
            font-weight: 400;
            font-style: normal;
            text-align: left;
        }
        nav {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: right;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
        }
        nav a:hover {
            background-color: #777;
        }
        section {
            display:flex;
            flex-direction:column;
            align-content:center;
            justify-content:center;
            background-color: red;
            padding: 100px;
            margin: 2vw;
            border-radius: 20px;
            text-align: center;
        }

        section #content{
            background-color: white;
            margin:30%;
            margin-top:0px;
            margin-bottom:0px;
            margin-bottom:10px;
            border-radius: 20px;
        }
        footer {
            background-color: #003664;
            color: #fff;
            text-align: center;
            padding: 40px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        form {
            text-align: center;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 20px;
        }
    </style>

<body>
    <header>
        <table>
            <tr><td><h1>Travel Together</h1></td>
                <td style='text-align: right;'>return</td> <!--l'alignement à droite ne marche pas-->
                <tr>
                <tr><td><p>Connecting People to Travel Together</p></td>
                <td></td>
            </tr>
        </table>
    </header>
    <nav>
        <a href="#">return</a>
    </nav>
    <section>
        <div id="content">
        <h2>Welcome to Travel Together!</h2>
        <p>Find travel buddies and explore the world together.</p>
        <p>Join our community and start planning your next adventure.</p>
        <h3>Login</h3>
        <!-- Add an id to the form for easier selection -->
        <form id="loginForm">
            <input type="text" id="username" name="username" placeholder="Username" required><br>
            <input type="password" id="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Start to Surf">
        </form>
        
        <p style='font-family: "Mansalva", sans-serif;'>Don't have an account? <br> <a href="registration.php">Create one</a></p>
        </div>
    </section>
    <footer>
        &copy; 2024 Travel Together | All Rights Reserved<br>
    </footer>
</body>