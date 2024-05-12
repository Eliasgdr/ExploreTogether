<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();
    
// Send a response back to the client
echo json_encode(['success' => true, 'message' => 'Disconnected successfully']);

?>