<?php
include 'php/databaseConnection.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the query
$user_id = $_SESSION['userID']; // Fetch user ID from session
$stmt = $conn->prepare("SELECT isPrenium FROM users WHERE ID = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($isPrenium);
$stmt->fetch();

// Check if the user is not premium
if (!$isPrenium) {
    header("Location: subscription.php"); // Redirect to subscription page if not premium
    exit;
}

// Close the connection
$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <link href="./stylessheet/messages.css?<?php echo time(); ?>" rel="stylesheet" type="text/css">
    <title>Message Threads</title>
    <script src="javascript/databaseRequest.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            getThreads(function(response) {
                if (response.success) {
                    const threads = response.threadInfo;
                    const threadContainer = $('.thread-container');
                    if (threads.length > 0) {
                        threads.forEach(thread => {
                            let threadHTML = `
                                <div class="thread">
                                    <h2><a href="chat.php?thread_id=${thread.threadID}">${thread.title}</a></h2>
                                    <p><strong>Last Message:</strong> ${thread.lastMessage ? thread.lastMessage : 'No message available'}</p>
                                    <p><strong>Date:</strong> ${thread.lastMessageDate ? thread.lastMessageDate : 'No date available'}</p>
                                
                            `;

                            if(isAdmin()){
                                threadHTML = threadHTML + `<a onclick=deleteMessage(${thread.threadID})>Delete msg</a>`
                            }
                            
                            threadHTML = threadHTML +` </div>`
    
                            threadContainer.append(threadHTML);
                        });
                    } else {
                        threadContainer.append('<p>You are not part of any threads.</p>');
                    }
                } else {
                    alert(response.message);
                }
            }, function(xhr, status, error) {
                alert('An error occurred while fetching threads: ' + error);
            });
        });
    </script>
</head>
<body>
    <header>
        <div class="title" onclick="window.location.href='welcome.php'">Explore Together</div>
        <div class="redirect">
            <a type="button" class="titleButton" onclick="window.location.href='welcome.php'">Retour</a>
            <?php echo '<a type="button" class="titleButton" onclick="window.location.href=\'profile.php?userID=' . $user_id . '\'">Profile</a>'; ?>
        </div>
    </header>
    <div class="container">
        <h1>Your Message Threads</h1>
        <div class="thread-container"></div>
    </div>
    <footer>
        &copy; 2024 Travel Together | All Rights Reserved
    </footer>
</body>
</html>