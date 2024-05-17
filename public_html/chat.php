<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="javascript/databaseRequest.js"></script>
    <title>Thread Discussion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            overflow: hidden;
            background-color: #333;
        }

        .navbar a {
            float: left;
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        h1,
        h2,
        h3 {
            margin-top: 0;
        }

        .message {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .message strong {
            font-weight: bold;
        }

        .message .time {
            color: #888;
            font-size: 12px;
        }

        .search-container {
            margin-bottom: 20px;
            position: relative;
        }

        .search-container input[type=text] {
            padding: 10px;
            width: 70%;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        .search-container input[type=submit] {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }

        #userSuggestions {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: calc(70% + 10px);
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            z-index: 1;
        }

        #userSuggestions ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #userSuggestions li {
            padding: 10px;
            cursor: pointer;
        }

        #userSuggestions li:hover {
            background-color: #f2f2f2;
        }
        
        .message {
            margin-bottom: 20px;
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 15px;
        }
        
        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
        }
        
        .message-author {
            font-weight: bold;
        }
        
        .message-time {
            font-size: 12px;
            color: #777;
        }
        
        .message-body {
            line-height: 1.5;
        }
        .navbar {
            overflow: hidden;
            background-color: #333;
            padding: 10px;
        }
        
        .navbar-btn {
            background-color: #555;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
        
        .navbar-btn:hover {
            background-color: #777;
        }

        .message {
            border: 1px solid #ccc;
            margin-bottom: 10px;
            padding: 10px;
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .message-author {
            font-weight: bold;
            margin-right: 10px;
        }

        .message-time {
            color: #666;
        }

        .message-body {
            margin-top: 10px;
        }

        .delete-message-btn,
        .edit-message-btn {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            margin-left: 5px;
            cursor: pointer;
        }

        .delete-message-btn:hover,
        .edit-message-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <div class="navbar">
        <button class="navbar-btn" onclick="window.location.href='welcome.php'">Return to Welcome Page</button>
        <button class="navbar-btn" onclick="quitThread(<?php echo $_GET['thread_id']?>, quiThreadCallBackSuccess, quiThreadCallBackError)">Leave Chat</button>
    </div>
    <div class="container">
        <h1>Thread Discussion</h1>

        <?php if (true or $thread && $messages) : ?>
        <h2><?php echo htmlspecialchars($_GET['thread_id']); ?></h2>
        <p><?php echo htmlspecialchars($_GET['thread_id']); ?></p>

        <h3>Messages:</h3>
        <div id="messagesContainer" class="messages-container">
            <!-- Messages will be appended here -->
        </div>
        

        <h3>Post a Message:</h3>
        <form id="messageForm">
            <textarea id="message" name="message" rows="4" cols="50" required></textarea><br>
            <input type="hidden" id="threadID" name="thread_id" value="<?php echo $_GET['thread_id']; ?>">
            <input  type="submit" value="Post Message">
        </form>





        <h3>Add User to Thread:</h3>
        <form id="addUserForm" class="search-container">
            <input type="text" id="usernameInput" name="username" placeholder="Enter username" required>
            <input type="hidden" name="threadID" value="<?php echo $_GET['thread_id']; ?>">
            <input type="submit" value="Add User">
            <div id="userSuggestions"></div>
        </form>
        <?php else : ?>
        <p>No thread or messages found.</p>
        <?php endif; ?>
    </div>

    <script>
    
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
                getMessages(<?php echo $_GET['thread_id']; ?>, getMessageCallBackSuccess, getMessageCallBackError);
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
            getMessages(<?php echo $_GET['thread_id']; ?>, getMessageCallBackSuccess, getMessageCallBackError);
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
            header.append('<strong class="message-author">' + message.author + '</strong>');
            header.append('<span class="message-time">' + formatMessageTime(message.time) + '</span>');

            // Check if the author of the message is the current user
            if (message.authorID == <?php echo $_SESSION['userID'] ?>) {
                // Add buttons for deleting and editing messages
                header.append('<div class="message-actions"><button class="delete-message-btn" onclick="deleteMessage(' + message.id + ', deleteMessageCallBackSuccess, deleteMessageCallBackError)">Delete</button><button class="edit-message-btn" onclick="alert(\'WIP\')">Edit</button></div>');
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
        // Make AJAX request to load thread details
        $(document).ready(function() {
            getMessages(<?php echo $_GET['thread_id']; ?>, getMessageCallBackSuccess, getMessageCallBackError);
            
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
     
    


        function searchUsers(query) {
            // Encode the search query to ensure it's properly formatted for URL
            var encodedQuery = encodeURIComponent(query);
            
            // Construct the URL with the search query parameter
            var url = 'PHP/searchUsers.php?query=' + encodedQuery; // Update the path here
            
            // Create a new XMLHttpRequest object
            var xhr = new XMLHttpRequest();
            
            // Configure the AJAX request
            xhr.open('GET', url, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        // Check if response is not empty
                        if (xhr.responseText.trim() !== "") {
                            // Handle the response here
                            var response = JSON.parse(xhr.responseText);
                            console.log(response);
                            showSuggestions(response); // Display suggestions based on response
                        } else {
                            console.log("Empty response received.");
                        }
                    } else {
                        console.log("Error: " + xhr.status + " - " + xhr.statusText);
                    }
                }
            };
            
            // Send the AJAX request
            xhr.send();
        }
        
        function showSuggestions(suggestions) {
            var suggestionsContainer = document.getElementById('userSuggestions');
            suggestionsContainer.innerHTML = ''; // Clear previous suggestions
        
            if (suggestions.length > 0) {
                suggestionsContainer.style.display = 'block';
                var ul = document.createElement('ul');
                suggestions.forEach(function(suggestion) {
                    var li = document.createElement('li');
                    var username = suggestion.username;
                    li.textContent = username;
                    var addButton = document.createElement('button');
                    addButton.textContent = 'Add to thread';
                    addButton.addEventListener('click', function() {
                        event.preventDefault(); // Prevent the default form submission behavior
                        addToThread(suggestion.ID, <?php echo $_GET['thread_id']; ?>);
                    });
                    li.appendChild(addButton);
                    ul.appendChild(li);
                });
                suggestionsContainer.appendChild(ul);
            } else {
                suggestionsContainer.style.display = 'none';
            }
        }

        function hideSuggestions() {
            document.getElementById('userSuggestions').style.display = 'none';
        }
        
        document.getElementById('usernameInput').addEventListener('input', function(event) {
            var query = event.target.value;
            if (query.length >= 2) {
                searchUsers(query); // Call the searchUsers function with the query
            } else {
                hideSuggestions();
            }
        });
    </script>
</body>

</html>