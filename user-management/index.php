<?php 
 session_start();

 // Check if user is logged in, if not redirect to login page
 if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
     header("location: dashboard.php");
     exit;
 } else{
     header("location: login.php");
     exit;
 }
?>