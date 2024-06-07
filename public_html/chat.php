<?php

session_start();


if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="javascript/databaseRequest.js?<?php echo time(); ?>"></script>
    <link href="./stylessheet/chat.css?<?php echo time(); ?>" rel="stylesheet" type="text/css">
    <script src="javascript/chatAddUsr.js?<?php echo time(); ?>"></script>


    <title>Thread Discussion</title>

</head>

<body>
    <header> 
        <div class="title">Explore Together</div>
        <div class="redirect">
            <a type="button" class="titleButton" onclick="window.location.href='welcome.php'">Retour</a>
            <?php echo '<a type="button" class="titleButton" onclick="window.location.href=\'profile.php?userID=' . $user_id . '\'">Profile</a>'; ?>
        </div>
    </header>

    <div class="container">
        <div class="thread">
            <div class="threadProfile">
                <img src="./images/Png.png" alt="" class="imageProfile">
                <p id="threadOwnerName" class="username">awdawd</p>
            </div>
            <!-- Elias integre les message pour les thread -->
            <img src="./images/landscape.jpg" alt="" class="imageTread">
            <p class="message" id="descThread"></p>
            
        </div>

        

        <div class="threadComment">
            <?php if (true or $thread && $messages) : ?>
                <!--<h2><?php echo htmlspecialchars($_GET['thread_id']); ?></h2>-->
                <!-- <p><?php echo htmlspecialchars($_GET['thread_id']); ?></p>-->

            <h3>Messages:</h3>
            <div id="messagesContainer" class="messages-container"></div>

            
    
            <form id="messageForm">
                <textarea id="message" name="message" rows="4" cols="50" required placeholder='Post a Message'></textarea><br>
                <input type="hidden" id="threadID" name="thread_id" value="<?php echo $_GET['thread_id']; ?>">
                <input class='btn' type="submit" value="Post Message">
            </form>
            
            <!---<h3>Add User to Thread:</h3>
            <form id="addUserForm" class="search-container">
                <input type="text" id="usernameInput" name="username" placeholder="Enter username" required>
                <input type="hidden" name="threadID" value="<?php echo $_GET['thread_id']; ?>">
                <input type="submit" value="Add User">
                <div id="userSuggestions"></div>
            </form>/--->

            <?php else : ?>
                <p>No thread or messages found.</p>
            <?php endif; ?>

            <div class="usrSearch">
                <button class='btn' id="searchUsr">Add User</button> 
                <button id='imgReport'><img src="./images/report.png"></button>
            </div>
        </div>
    
        
        <div class="addUsrSearch">
            <img class="close" src="./images/x.png">
            <div class="searchContainer" id="searchContainer">
                <h3>Search Users:</h3>
                <form id="searchUsersForm">
                    <label for="search">Search:</label>
                    <input type="text" id="SearchUserQuery" name="query" placeholder="Enter username">
                </form>
            </div>
            <div class="suggestions" id='suggestions'></div>
        </div>

        

    </div>


    <div class="reportUsr">
        <img id='close' src="./images/x.png">
        <a onclick="report(<?php echo $_GET['thread_id']; ?>, 'Spam', tt, t)">Spam</a>
        <a onclick="report(<?php echo $_GET['thread_id']; ?>, 'Violence')">Violence</a>
        <a onclick="report(<?php echo $_GET['thread_id']; ?>, 'Nudity')">Nudity</a>
        <a onclick="report(<?php echo $_GET['thread_id']; ?>, 'Harrasment')">Harrasment</a>
    </div>

    <footer>
        &copy; 2024 Travel Together | All Rights Reserved
    </footer>

    <script>

        function tt(response) {};
        function t(xhr, status, error) {
            console.log(xhr);

        }
        function quiThreadCallBackSuccess(response) {
            if (response.success) {
                alert(response.message);
                window.location.href = "welcome.php";
            } else {
                alert(response.message);
            }
        }

        function quiThreadCallBackError(xhr, status, error) {

        }

        function postMessageCallBackSuccess(response) {
            if (response.success) {
                //alert(response.message);
                getThread(<?php echo $_GET['thread_id']; ?>, getThreadCallBackSuccess, getThreadCallBackError);
                $("#message").val('');
            } else {
                alert(response.message);
            }
        }

        function postMessageCallBackError(xhr, status, error) {
            alert('Error');
        }

        $(document).ready(function() {
            // Intercept form submission
            $('#messageForm').submit(function(e) {
                e.preventDefault(); // Prevent default form submission

                // Serialize form data
                //var formData = $(this).serialize();

                var message = $("#message").val();
                var threadID = $("#threadID").val();

                // Send AJAX request
                postMessage(message, threadID, postMessageCallBackSuccess, postMessageCallBackError);
            });
        });

        function renderMessages(messages) {
            // Clear existing messages
            $('#messagesContainer').empty();

            // Iterate over each message
            messages.forEach(function(message) {
                // Create HTML elements for each message
                var messageElement = createMessageElement(message);

                // Append the message HTML to the messages container
                $('#messagesContainer').append(messageElement);
            });
        }

        function deleteMessageCallBackSuccess(response) {
            getThread(<?php echo $_GET['thread_id']; ?>, getThreadCallBackSuccess, getThreadCallBackError);
        }

        function deleteMessageCallBackError(xhr, status, error) {
            alert('Error');
        }

        function editMessageCallBackSuccess(response) {
                console.log(response.message);
        }

        function editMessageCallBackError(xhr, status, error) {
            alert('Error');
        }

        function createMessageElement(message) {
            // Create the message container
            var messageContainer = $('<div class="message"></div>');

            // Create the message header
            var header = $('<div class="message-header"></div>');
            header.append('<strong class="message-author">' + message.authorUsername + '</strong>');
            header.append('<span class="message-time">' + formatMessageTime(message.Date) + '</span>');

            // Check if the author of the message is the current user
            if (message.authorID == <?php echo $_SESSION['userID'] ?>) {
                // Add buttons for deleting and editing messages
                header.append('<div class="message-actions"><button class="delete-message-btn" onclick="deleteMessage(' + message.messageID + ', deleteMessageCallBackSuccess, deleteMessageCallBackError)">Delete</button><button class="edit-message-btn" onclick="alert(\'WIP\')">Edit</button></div>');
            }

            // Append the header to the message container
            messageContainer.append(header);

            // Create the message body
            var body = $('<div class="message-body">' + message.body + '</div>');

            // Append the body to the message container
            messageContainer.append(body);

            // Return the complete message element
            return messageContainer;
        }

        // Helper function to format message time
        function formatMessageTime(time) {
            var formattedTime = new Date(time).toLocaleString(); // Convert time to local string format
            return formattedTime;
        }

        function getMessageCallBackSuccess(response) {
            renderMessages(response['messages']);
            console.log(response);
        }

        function getMessageCallBackError(xhr, status, error) {
            // Alert error message
            console.log(xhr);
        }

        function getThreadCallBackSuccess(response) {
            renderMessages(response['threadInfo']['messages']);
            $('#threadOwnerName').text(response['threadInfo']['description']);
            $('#descThread').text(response['threadInfo']['ownerUsername']);
            console.log(response);
        }

        function getThreadCallBackError(xhr, status, error) {
            // Alert error message
            console.log(xhr);
        }

        // Make AJAX request to load thread details
        $(document).ready(function() {
            //getMessages(<?php echo $_GET['thread_id']; ?>, getMessageCallBackSuccess, getMessageCallBackError);
            getThread(<?php echo $_GET['thread_id']; ?>, getThreadCallBackSuccess, getThreadCallBackError);

        });

        // Function to handle form submission using AJAX
        // Get form data
        function addToThread(user, thread) {
            var threadID = encodeURIComponent(thread);
            var userID = encodeURIComponent(user);
            // Send AJAX request
            $.ajax({
                type: 'POST',
                url: 'PHP/addUserToThread.php', // URL of the PHP script
                data: {threadID: threadID, userID: userID}, // Form data to be sent
                success: function(response) {
                    // Handle the success response
                    alert(response); // Display success message or handle response as needed
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText); // Log error message
                    alert('An error occurred while processing your request. Please try again later.'); // Display error message
                }
            });
        }

        function createProfileDiv(user) {
            const profileDiv = document.createElement('div');
            profileDiv.className = 'threadProfile';
            profileDiv.onclick = function() {
                addUserToThread(user.ID, function() {
                    alert('Ami ajouté au thread avec succès');
                }, function() {
                    alert('Échec de l\'ajout du thread');
                });
            };

            const usernameParagraph = document.createElement('p');
            usernameParagraph.className = 'username';
            usernameParagraph.textContent = `${user.username}`;


            const profileImage = document.createElement('img');
            profileImage.className = 'imageProfile';
            profileImage.id = 'imageProfile';
            profileImage.src = user.profileImage || './images/Png.png';

            profileDiv.appendChild(usernameParagraph);
            profileDiv.appendChild(profileImage);

            return profileDiv;
        }


        function searchUsersCallBackSuccess(response) {
            console.log(response);
                  // Select the suggestions div
            const suggestionsDiv = document.getElementById('suggestions');

            suggestionsDiv.innerHTML = '';
            // Loop through the data and append the created profile divs to the suggestions div
            response['data'].forEach(user => {
                const profileDiv = createProfileDiv(user);
                suggestionsDiv.appendChild(profileDiv);
            });
        }

        function searchUsersCallBackError(xhr, status, error) {
            // Alert error message
            console.log(xhr);
        }
        document.getElementById('SearchUserQuery').addEventListener('input', function(event) {
            var query = event.target.value;
            //if (query.length >= 2) {
                searchUsers(query, searchUsersCallBackSuccess, searchUsersCallBackError); // Call the searchUsers function with the query
            //} else {
                //hideSuggestions();
            //}
        });
    </script>
</body>

</html>