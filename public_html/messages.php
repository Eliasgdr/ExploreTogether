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
                            const threadHTML = `
                                <div class="thread">
                                    <h2><a href="chat.php?thread_id=${thread.threadID}">${thread.title}</a></h2>
                                    <p><strong>Last Message:</strong> ${thread.lastMessage ? thread.lastMessage : 'No message available'}</p>
                                    <p><strong>Date:</strong> ${thread.lastMessageDate ? thread.lastMessageDate : 'No date available'}</p>
                                </div>
                            `;
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
        <div class="title">Explore Together</div>
        <div class="redirect">
            <a type="button" class="titleButton" onclick="window.location.href='welcome.php'">Messages</a>
            <a type="button" class="titleButton" onclick="window.location.href='profile.php'">Profile</a>
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