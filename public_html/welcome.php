<?php
    session_start();
    //print_r($_SESSION);

    // Check if the user is logged in
    if (!isset($_SESSION['userID'])) {
        header("Location: login.php"); // Redirect to login page if not logged in
        exit;
    }
$user_id = $_SESSION['userID'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Travel Together</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="javascript/databaseRequest.js?<?php echo time(); ?>"></script>
    <script src="javascript/jsButton.js?<?php echo time(); ?>"></script>

    <link href="./stylessheet/welcome.css?<?php echo time(); ?>" rel="stylesheet" type="text/css">
    <audio id="hoverAudio" src="./audio/pedro.mp3"></audio>
</head>
<body>
    <header> 
        <div class="title">Explore Together</div>
        <div class="redirect">
            <a type="button" class="titleButton" onclick="redirectMessages()">Messages</a>
            <?php echo '<a type="button" class="titleButton" onclick="window.location.href=\'profile.php?userID=' . $user_id . '\'">Profile</a>'; ?>

        </div>
    </header>


    <div class="containerMessage" id='containerMessage'>
        <div class="thread-container" id="threadContainer"></div>
        <div class="createThreadContainer">

            <form id="createThreadForm" method="post" enctype="multipart/form-data">
                <h3>Create a New Thread:</h3>
                <label for="title">Thread Title:</label><br>
                <input type="text" id="title" name="title" required><br><br>
                <label for="description">Description:</label><br>
                <textarea id="description" name="description" rows="8" cols="50" required ></textarea><br><br>
                
                <input class='btn' type="submit" value="Create Thread">
            </form>

            <div class="usrSearch">
                <h3>Add User :</h3>
                <button class='btn' id="searchUsr">wadawd</button>
            </div>
            
            <div class='disconnectDiv'>
                <button class='btn' id="disconnectBtn">Disconnect</button>
            </div>
        </div>

        <div class="addUsrSearch">
            <img class="close" src="./Fs/x.png">
            <div class="searchContainer" id="searchContainer">
                <h3>Search Users:</h3>
                <form id="searchUsersForm">
                    <label for="search">Search:</label>
                    <input type="text" id="SearchUserQuery" name="query" placeholder="Enter username">
                </form>
            </div>
            <div class="suggestions" id='suggestions'>
            </div>
        </div>

    </div>

    


    <footer>
        &copy; 2024 Travel Together | All Rights Reserved
    </footer>
        <script>

        function createProfileDiv(user) {
            const profileDiv = document.createElement('div');
            profileDiv.className = 'threadProfile';
            profileDiv.onclick = function() {
                addFriend(user.ID, function() {
                    alert('Ami ajouté avec succès');
                }, function() {
                    alert('Échec de l\'ajout de l\'ami');
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
                searchUsers(query, searchUsersCallBackSuccess, searchUsersCallBackError); // Call the searchUsers function with the query
        });
        
        function disconnectSuccessCallback(response) {
            window.location.href = 'login.php';
        }
        function disconnectErrorCallback(xhr, status, error) {
            console.error('Error:', error);
            alert('Failed to disconnect. Please try again.');
        }

        function getPublicInfosuccessCallback(response, threadDiv) {
            // This function will be called if the request is successful
            console.log("Public info retrieved successfully:", response);
            // Update the username in the threadDiv
            const usernameElement = threadDiv.querySelector('.username');
            if (usernameElement) {
                usernameElement.textContent = response.data['name'];
            }
}

        function getPublicInfoerrorCallback() {
            // This function will be called if the request encounters an error
            console.error("Error retrieving public info.");
        }


        function renderThreadInfo(threadInfo, containerID) {
            // Create a container for the thread information
            console.log(threadInfo);
            const container = $(containerID);

            container.empty();

            if (!container.length) {
                console.error('Container element not found.');
                document.querySelector('footer').classList.add('addSize');
                return;
            }
            else{
                document.querySelector('footer').classList.remove('addSize');
            }

            // Loop through each thread in the threadInfo array
            threadInfo.forEach(thread => {

                if (thread['ownerID'] !== null) {
                    getPublicInfo(thread['ownerID'],
                        function(response) {
                            // Success callback function to update username
                            getPublicInfosuccessCallback(response, threadDiv);
                        },
                        getPublicInfoerrorCallback
                    );
                }

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
                lastMessageImgProfile.setAttribute("id", "imageProfile");
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
            console.log('Error:', error);
            console.log('Error:', xhr);
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