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

function addFriend(friendID, successCallback, errorCallback) {
    $.ajax({
        url: "PHP/addFriend.php",
        type: "POST",
        data: { friendID: friendID },
        dataType: "json",
        success: function(response) {
            /* 
            Format of response :
                
            $response['success'] = true/false; (true = User connected)
            $response['message'] = "Incorrect password"; (Hold the message explaining why the user couldn' connect)
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
                
            $response['success'] = true/false; (true = User connected)
            $response['message'] = "Incorrect password"; (Hold the message explaining why the user couldn' connect)
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

function getMessages(threadID, successCallback, errorCallback) {
    $.ajax({
        url: 'PHP/getMessages.php',
        type: 'POST',
        dataType: 'json',
        data: {
            thread_id: threadID
        },
        success: function(response) {
            /* 
            Format of response :
                
            $response['success'] = true/false; (true = User connected)
            $response['message'] = "Incorrect password"; (Hold the message explaining why the user couldn' connect)
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
                        
            $response['success'] = true/false; (true = User connected)
            $response['message'] = "Incorrect password"; (Hold the message explaining why the user couldn' connect)
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


/*
Under this the fonctions are not ready for production
*/

//Request the server all the Threads that the User follow. The result will be show in the container with the containerID ID


function getThreads(containerID) {
    $.ajax({
        url: 'PHP/getThreads.php', // Path to your disconnect PHP script
        type: 'POST', // Use POST method
        dataType: 'json',
        success: function(response) {
            // Handle success response
            console.log(response);
            $(containerID).html(response.html);
        },
        error: function(xhr, status, error) {
            // Handle error response
            console.error('Error:', error);
            alert('Failed to disconnect. Please try again.');
        }
    });
}







