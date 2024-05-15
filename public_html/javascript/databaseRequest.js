function login(username, password, successCallback, errorCallback) {
    $.ajax({
            url: "PHP/login.php", // Path to your login PHP script
            type: "POST", // Use POST method
            data: {username: username, password: password}, // Form data
            dataType: "json",
            success: function(response){
                /* 
                Format of response :
                
                $response['success'] = true/false; (true = User connected)
                $response['message'] = "Incorrect password"; (Hold the message explaining why the user couldn' connect)
                */
                if (successCallback && typeof successCallback === 'function') {
                    successCallback(response);
                }
            },
            error: function(xhr, status, error){
                if (errorCallback && typeof errorCallback === 'function') {
                    errorCallback(xhr, status, error);
                }
            }
    });
}

function registration(username, password, birthdate, gender, successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/register.php', // Update with your PHP script's filename
        type: 'POST',
        data: {name: username, gender:gender, birthdate:birthdate, password:password},
        dataType: 'json',
        success: function(response) {
                /* 
                Format of response :
                
                $response['success'] = true/false; (true = User registered)
                $response['message'] = "Incorrect password"; (Hold the message explaining why the user couldn' register)
                */
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
} 

function disconnect(successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/disconnect.php', // Path to your disconnect PHP script
        type: 'POST', // Use POST method
        success: function(response) {
                /* 
                Format of response :
                
                $response['success'] = true/false;
                $response['message'] = "Details about what happens"
                */
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}

function postMessage(message, threadID, successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/postMessage.php',
        type: 'POST',
        data: {message: message, threadID: threadID},
        dataType: 'json',
        success: function(response) {
                /* 
                Format of response :
                
                $response['success'] = true/false;
                $response['message'] = "Details about what happens"
                */
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}

function deleteMessage(messageID, successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/deleteMessage.php',
        type: 'POST',
        data: {messageID: messageID},
        dataType: 'json',
        success: function(response) {
            /* 
            Format of response :
            
            $response['success'] = true/false;
            $response['message'] = "Details about what happens"
            */
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}

function editMessage(messageID, newMessage, successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/editMessage.php',
        type: 'POST',
        data: {messageID: messageID, newMessage: newMessage},
        dataType: 'json',
        success: function(response) {
            /* 
            Format of response :
            
            $response['success'] = true/false;
            $response['message'] = "Details about what happens"
            */
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}

function getMessages(threadID, successCallback, errorCallback, limit=10, offset=0) {
    $.ajax({
        url: 'PHP/getMessages.php',
        type: 'POST',
        dataType: 'json',
        data: {
            thread_id: threadID,
            limit: limit,
            offset: offset
        },
        success: function(response) {
                /* 
                Format of response :
                
                $response['success'] = true/false;
                $response['message'] = "Details about what happens"
                */
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}

function createThread(title, description, successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/createThread.php', // Path to your disconnect PHP script
        type: 'POST', // Use POST method
        data: {title: title, description:description}, 
        datatype: 'json',
        success: function(response) {
                console.log(response);
                /* 
                Format of response :
                
                $response['success'] = true/false;
                $response['message'] = "Details about what happens"
                */
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}

function quitThread(threadID, successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/quitThread.php',
        type: 'POST',
        dataType: 'json',
        data: {
            threadID: threadID
        },
        success: function(response) {
                /* 
                Format of response :
                
                $response['success'] = true/false;
                $response['message'] = "Details about what happens"
                */
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}

function getThreads(successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/getThreads.php', // Path to your disconnect PHP script
        type: 'POST', // Use POST method
        dataType: 'json',
        success: function(response) {
                /* 
                Format of response :
                
                $response['success'],       true/false;
                $response['message'],       "Details about what happens"
                $response['threadInfo'] = {
                    'threadID',             "int"
                    'lastMessage',          "Text"
                    'lastMessageDate'       "timestamp"
                }
                */
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}

function addUserToThread(threadID, userID, successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/addUserToThread.php', // Path to your PHP script for adding user to thread
        type: 'POST', // Using POST method
        dataType: 'json',
        data: { threadID: threadID, userID: userID }, // Pass threadID and userID as parameters
        success: function(response) {
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}

function searchUsers(query, successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/searchUsers.php', // Path to your PHP script for searching users
        type: 'GET', // Using GET method to pass the search query as a parameter
        dataType: 'json',
        data: { query: query }, // Pass the search query as a parameter
        success: function(response) {
            /*
            Format of response:
            
            response['success']:       true/false;
            response['message']:       "Details about what happens"
            response['users']:         Array of user information objects
            {
                'ID':                   "int"
                'username':             "string"
            }
            */

            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}



function addFriend(friendID, successCallback, errorCallback) {
    $.ajax({
        url: "PHP/addFriend.php",
        type: "POST",
        data: { friendID: friendID },
        dataType: "json",
        success: function(response) {
                /* 
                Format of response :
                
                $response['success'] = true/false;
                $response['message'] = "Details about what happens"
                */
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}

function removeFriend(friendID, successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/removeFriend.php', // Path to your PHP script for removing friend
        type: 'POST', // Using POST method
        dataType: 'json',
        data: { friendID: friendID }, // Pass friendID as parameter
        success: function(response) {
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}


function blockUser(userIDToBlock, successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/blockUser.php', // Path to your PHP script for blocking user
        type: 'POST', // Using POST method
        dataType: 'json',
        data: { userIDToBlock: userIDToBlock }, // Pass userIDToBlock as parameter
        success: function(response) {
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}

function unblockUser(userIDToUnblock, successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/unblockUser.php', // Path to your PHP script for unblocking user
        type: 'POST', // Using POST method
        dataType: 'json',
        data: { userIDToUnblock: userIDToUnblock }, // Pass userIDToUnblock as parameter
        success: function(response) {
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}






