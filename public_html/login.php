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

    <link href="https://fonts.googleapis.com/css2?family=Mansalva&display=swap" rel="stylesheet">

    <link href="./stylessheet/login.css" rel="stylesheet" type="text/css">

<body>  
    <header>
        <div class="title">Explore Together</div>
        <div class="redirect">
            <a type="button" class="titleButton" href="registration.php">Sign in</a>
        </div>
    </header>
    <section>
        <div id="content">
            <h2>Welcome to Eplore Together!</h2>
            <p>Find travel buddies and explore the world together.</p>
            <p>Join our community and start planning your next adventure.</p>
            <h3>Log in</h3>
            <!-- Add an id to the form for easier selection -->
            <form id="loginForm">
                <input type="text" id="username" name="username" placeholder="Username" required><br>
                <input type="password" id="password" name="password" placeholder="Password" required><br>
                <input type="submit" value="Start to Surf">
            </form>
            
            <p style='font-family: "Mansalva", sans-serif;'>Don't have an account ? <br> <a href="registration.php">create one</a></p>
        </div>
    </section>
    <footer>
        &copy; 2024 Travel Together | All Rights Reserved<br>
    </footer>
</body>