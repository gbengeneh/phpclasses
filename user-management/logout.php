<?php 
 session_start();
 $SESSION = array(); // Clear all session variables
 session_destroy(); // Destroy the session

    // Redirect to login page
    header("location: login.php");
    exit;
?>