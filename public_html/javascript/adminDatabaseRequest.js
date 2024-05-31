function banEmail(email, successCallback, errorCallback) {
    $.ajax({
            url: "PHP/admin/banEmail.php", // Path to your login PHP script
            type: "POST", // Use POST method
            dataType: "json",
            data: {email: email},
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

function unbanEmail(emailID, successCallback, errorCallback) {
    $.ajax({
            url: "PHP/admin/unbanEmail.php", // Path to your login PHP script
            type: "POST", // Use POST method
            dataType: "json",
            data: {emailID: emailID},
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

function reportDone(reportID, isDone, successCallback, errorCallback) {
    $.ajax({
            url: "PHP/admin/reportDone.php", // Path to your login PHP script
            type: "POST", // Use POST method
            dataType: "json",
            data: {reportID: reportID, isDone:isDone},
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

function deleteReport(reportID, successCallback, errorCallback) {
    $.ajax({
            url: "PHP/admin/deleteReport.php", // Path to your login PHP script
            type: "POST", // Use POST method
            dataType: "json",
            data: {reportID: reportID},
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

function getReportsTodo(successCallback, errorCallback) {
    $.ajax({
            url: "PHP/admin/getReportsToDo.php", // Path to your login PHP script
            type: "POST", // Use POST method
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

function getAllReports(successCallback, errorCallback) {
    $.ajax({
            url: "PHP/admin/getAllReports.php", // Path to your login PHP script
            type: "POST", // Use POST method
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

function getAllConvsFromUser(userID, successCallback, errorCallback) {
    $.ajax({
            url: "PHP/admin/getAllConvsFromUser.php", // Path to your login PHP script
            type: "POST", // Use POST method
            dataType: "json",
            data: {user_id: userID},
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

function deleteMessageAdmin(messageID, successCallback, errorCallback) {
    $.ajax({
            url: "PHP/admin/deleteMessageAdmin.php", // Path to your login PHP script
            type: "POST", // Use POST method
            dataType: "json",
            data: {messageID: messageID},
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

function AdmindeleteAccount(userIDToDelete, successCallback, errorCallback) {
    $.ajax({
            url: "PHP/admin/adminDeleteAccount.php", // Path to your login PHP script
            type: "POST", // Use POST method
            dataType: "json",
            data : {userIDToDelete: userIDToDelete},
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
