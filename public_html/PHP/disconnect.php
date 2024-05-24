<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();
    
// Send a response back to the client
http_response_code(200); 
echo json_encode(['success' => true, 'status_text' => 'Disconnected successfully', 'status_code' => 200]);

?>