<?php
    session_start();
    //print_r($_SESSION);

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
    <link href="./stylessheet/welcome.css" rel="stylesheet" type="text/css">

</head>
<body>
    <header>
        <div class="title">Explore Together</div>
        <button class="titleButton"><a href="messages.php">Messages</a></button>
    </header>
    <div class="container">
        
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
                lastMessagePara.classList.add('message');
                lastMessagePara.textContent = `Last Message: ${thread.lastMessage}`;

                // Create a paragraph element for the last message date
                const lastMessageDatePara = document.createElement('p');
                lastMessageDatePara.classList.add('date');
                lastMessageDatePara.textContent = `Date: ${thread.lastMessageDate}`;

                const lastMessageImgTread = document.createElement('img');
                lastMessageImgTread.classList.add('imageTread');
                lastMessageImgTread.src = './images/landscape.jpg'; 

                //Profile pics and name

                const threadProfileDiv = document.createElement('div');
                threadProfileDiv.classList.add('threadProfile');

                const lastMessageImgProfile = document.createElement('img');
                lastMessageImgProfile.classList.add('imageProfile');
                lastMessageImgProfile.src = './images/Png.png'; 
                
                const lastMessageUserProfile = document.createElement('p');
                lastMessageUserProfile.classList.add('username');
                lastMessageUserProfile.textContent = `Username`;
                threadProfileDiv.appendChild(lastMessageUserProfile);
                threadProfileDiv.appendChild(lastMessageImgProfile);
                

                // Append the message and date paragraphs to the thread div
                threadDiv.appendChild(threadProfileDiv);

                threadDiv.appendChild(lastMessageImgTread);
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