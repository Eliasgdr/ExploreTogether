<?php
    session_start();
    print_r($_SESSION);

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
    <title>Welcome to Travel Together</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="javascript/databaseRequest.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            text-align: center;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
        }
        h1 {
            margin: 0;
        }
        .container {
            padding: 20px;
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .thread {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        #searchContainer {
            position: relative;
        }
        #suggestions {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: #f9f9f9;
            border: 1px solid #ccc;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1;
        }
        #suggestions ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        #suggestions li {
            padding: 10px;
            cursor: pointer;
        }
        #suggestions li:hover {
            background-color: #ddd;
        }
        
         /* Add your CSS styles here */
        .thread-container {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .thread {
            margin-bottom: 10px;
        }
    </style>

</head>
<body>
    <header>
        <h1>Welcome to Travel Together</h1>
    </header>
    <div class="container">
        <h2>Welcome, User!</h2>
        <p>You have successfully logged in to Travel Together.</p>
        <p>Start planning your next adventure now!</p>

        <h3>Threads You Are Following:</h3>
        <div class="thread-container" id="threadContainer"></div>
        
        
        <h3>Create a New Thread:</h3>
        <form id="createThreadForm" method="post">
            <label for="title">Thread Title:</label><br>
            <input type="text" id="title" name="title" required><br><br>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="4" cols="50" required></textarea><br><br>
            <input type="submit" value="Create Thread">
        </form>
        
        <div id="searchContainer">
            <h3>Search Users:</h3>
            <form id="searchUsersForm">
                <label for="search">Search:</label>
                <input type="text" id="query" name="query" placeholder="Enter username">
                <div id="suggestions"></div>
            </form>
        </div>
        
        <div>
            <h3>Disconnect:</h3>
            <button id="disconnectBtn">Disconnect</button>
        </div>
        
    </div>
    <footer>
        &copy; 2024 Travel Together | All Rights Reserved
    </footer>
        <script>
        function createThreadCallBackSuccess(response){
            if (response.success) {
                getThreads(getThreadSuccessCallback, getThreadErrorCallback);
                
            } else {
                // Handle failure case (e.g., display error message)
                alert(response.message);
            }
        }
        
        function createThreadCallBackError(xhr, status, error){
            alert('Error');
        }
        
        $(document).ready(function(){
            $("#createThreadForm").submit(function(event){
                event.preventDefault();
                
                var title = $("#title").val();
                var description = $("#description").val();
                
                createThread(title, description, createThreadCallBackSuccess, createThreadCallBackError);
            });
        });


        function addFriendCallBackSuccess(response) {
            if (response.success) {
                alert(response.message);
            } else {
                alert(response.message);
            }
        }

        function addFriendCallBackError(xhr, status, error) {
            alert('Error'); // Display a generic error message
        }
        
        function searchUsersA(query) {
            // Encode the search query to ensure it's properly formatted for URL            
            // Construct the URL with the search query parameter
            searchUsers(query, function(response) {
                if (response.success) {
                    console.log(response.data);
                } else {
                    console.error("Error: " + response.status_text);
                }
            }, function(xhr, status, error) {
                console.error("AJAX Error: " + status + " - " + error);
                console.error(xhr);
            });
        }
        
        document.getElementById('query').addEventListener('input', function(event) {
            var query = event.target.value;
            if (query.length >= 2) {
                searchUsersA(query); // Call the searchUsers function with the query
            } else {
                hideSuggestions();
            }
        });
        
        function disconnectSuccessCallback(response) {
            window.location.href = 'login.php';
        }
        function disconnectErrorCallback(xhr, status, error) {
            console.error('Error:', error);
            alert('Failed to disconnect. Please try again.');
        }


        function renderThreadInfo(threadInfo, containerID) {
            // Create a container for the thread information
            console.log(threadInfo);
            const container = $(containerID);

            container.empty();

            if (!container.length) {
                console.error('Container element not found.');
                return;
            }

            // Loop through each thread in the threadInfo array
            threadInfo.forEach(thread => {
                // Create a div element to hold the thread information
                const threadDiv = document.createElement('div');
                threadDiv.classList.add('thread');

                // Set the thread ID as a data attribute
                $(threadDiv).data('thread-id', thread.threadID);

                // Create a paragraph element for the last message
                const lastMessagePara = document.createElement('p');
                lastMessagePara.textContent = `Last Message: ${thread.lastMessage}`;

                // Create a paragraph element for the last message date
                const lastMessageDatePara = document.createElement('p');
                lastMessageDatePara.textContent = `Last Message Date: ${thread.lastMessageDate}`;

                // Append the message and date paragraphs to the thread div
                threadDiv.appendChild(lastMessagePara);
                threadDiv.appendChild(lastMessageDatePara);

                // Attach onclick event to redirect to chat.php with thread ID
                $(threadDiv).click(function() {
                    const threadID = $(this).data('thread-id');
                    window.location.href = `chat.php?thread_id=${threadID}`;
                });

                // Append the thread div to the container
                container.append(threadDiv); // Use jQuery's append method instead of native appendChild
            });
        }

        // Call the renderThreadInfo function with the threadInfo array

        function getThreadSuccessCallback(response) {
            // Assuming response is the thread information array
            renderThreadInfo(response['threadInfo'], "#threadContainer");
        }

        function getThreadErrorCallback(xhr, status, error) {
            console.error('Error:', error);
            console.error('Error:', xhr);
            alert('Failed to get thread information. Please try again.');
        }

        $(document).ready(function() {
            getThreads(getThreadSuccessCallback, getThreadErrorCallback);

            $('#disconnectBtn').click(function() {
                disconnect(disconnectSuccessCallback, disconnectErrorCallback);
            });
            
            
            
        });

    </script>
</body>
</html>