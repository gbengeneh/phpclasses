<?php 
 require 'db.php';

    //process form data when form is submitted
    try{
       if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name=$_POST['name'];
        $email=$_POST['email'];
        $message=$_POST['message'];

        //prepare insert statement
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)");
        $stmt->execute(['name' => $name, 'email' => $email, 'message' => $message]);
       }
    }catch(PDOException $e){
        die("ERROR: Could not process form data. " . $e->getMessage());
    }
?>