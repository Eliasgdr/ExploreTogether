
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
    <link href="./stylessheet/chat.css" rel="stylesheet" type="text/css">
    <title>Thread Discussion</title>

</head>

<body>
    <<header>
        <div class="title">Explore Together</div>

        <button class="titleButton"><a href="messages.php">Retour</a></button>

    </header>
    <div class="container">
        <h1>Thread Discussion</h1>

        <?php if (true or $thread && $messages) : ?>
        <h2><?php echo htmlspecialchars($_GET['thread_id']); ?></h2>

        <div id="messagesContainer" class="messages-container">
            <!-- Messages will be appended here -->
        </div>

        <form id="messageForm">
            <textarea id="message" name="message" rows="4" cols="50" required></textarea><br>
            <input type="hidden" id="threadID" name="thread_id" value="<?php echo $_GET['thread_id']; ?>">
            <input type="submit" value="Post Message">
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
        $(document).ready(function() {
            // Load messages on page load
            getMessages(<?php echo $_GET['thread_id']; ?>, getMessageCallBackSuccess, getMessageCallBackError);

            // Post message form submission
            $('#messageForm').submit(function(e) {
                e.preventDefault();
                var message = $("#message").val();
                var threadID = $("#threadID").val();
                postMessage(message, threadID, postMessageCallBackSuccess, postMessageCallBackError);
            });

            // Search users
            $('#usernameInput').on('input', function(event) {
                var query = event.target.value;
                if (query.length >= 2) {
                    searchUsers(query);
                } else {
                    hideSuggestions();
                }
            });
        });

        function renderMessages(messages) {
            $('#messagesContainer').empty();
            messages.reverse().forEach(function(message) {
                var messageElement = createMessageElement(message);
                $('#messagesContainer').append(messageElement);
            });
        }

        function createMessageElement(message) {
            var messageContainer = $('<div class="message"></div>');
            messageContainer.addClass(message.authorID == <?php echo $_SESSION['userID'] ?> ? 'sent' : 'received');

            var author = $('<span class="message-author"></span>').text(message.author);
            var body = $('<p class="message-body"></p>').text(message.body);
            var time = $('<span class="time"></span>').text(formatMessageTime(message.time));

            messageContainer.append(author).append(body).append(time);

            return messageContainer;
        }

        function formatMessageTime(time) {
            return new Date(time).toLocaleString();
        }

        function postMessageCallBackSuccess(response) {
            if (response.success) {
                getMessages(<?php echo $_GET['thread_id']; ?>, getMessageCallBackSuccess, getMessageCallBackError);
                $("#message").val('');
            } else {
                alert(response.message);
            }
        }

        function postMessageCallBackError(xhr, status, error) {
            alert('Error posting message.');
        }

        function getMessageCallBackSuccess(response) {
            renderMessages(response.messages);
        }

        function getMessageCallBackError(xhr, status, error) {
            alert('Error loading messages.');
        }

        function searchUsers(query) {
            $.ajax({
                type: 'GET',
                url: 'PHP/searchUsers.php',
                data: { query: query },
                success: function(response) {
                    if (response.trim() !== "") {
                        var users = JSON.parse(response);
                        showSuggestions(users);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function showSuggestions(users) {
            var suggestionsContainer = $('#userSuggestions');
            suggestionsContainer.empty().show();

            var list = $('<ul></ul>');
            users.forEach(function(user) {
                var listItem = $('<li></li>').text(user.username).data('userId', user.id);
                listItem.on('click', function() {
                    $('#usernameInput').val(user.username);
                    suggestionsContainer.hide();
                });
                list.append(listItem);
            });

            suggestionsContainer.append(list);
        }

        function hideSuggestions() {
            $('#userSuggestions').hide();
        }
    </script>
</body>

</html>
