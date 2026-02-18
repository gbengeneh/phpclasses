<?php 
  session_start();
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: login.php");
        exit;
    }
    require_once 'config/database.php';

    $user_id = $_SESSION["id"];

    $firstname = $lastname = $username = $email = $created_at = $profile_image = "";
    $firstname_err = $lastname_err = $username_err = $email_err = $profile_image_err = $update_success =$profile_image_err ="";

    // get current user information
    $sql= "SELECT firstname, lastname, username, email, profile_image FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch();

    $firstname = $user['firstname'];
    $lastname = $user['lastname'];
    $username = $user['username'];
    $email = $user['email'];
    $profile_image = $user['profile_image'];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Validate first name
        if(empty(trim($_POST["firstname"]))){
            $firstname_err = "Please enter your first name.";
        } else{
            $firstname = trim($_POST["firstname"]);
        }

        // Validate last name
        if(empty(trim($_POST["lastname"]))){
            $lastname_err = "Please enter your last name.";
        } else{
            $lastname = trim($_POST["lastname"]);
        }

        // Validate username
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter a username.";
        } else{
            $new_username = trim($_POST["username"]);

            // Check if username is already taken
            if($new_username !== $username){
                $check_sql = "SELECT id FROM users WHERE username = :username AND id != :id";
                $check_stmt = $pdo->prepare($check_sql);
                $check_stmt->bindParam(":username", $new_username, PDO::PARAM_STR);
                $check_stmt->execute();

                if($check_stmt->rowCount() > 0){
                    $username_err = "This username is already taken.";
                } else{
                    $username = $new_username;
                }
                unset($check_stmt);
            }
        }
        // validate email
        if(empty(trim($_POST["email"]))){
            $email_err = "Please enter your email.";
        }elseif(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)){
            $email_err = "Please enter a valid email address.";
        } else{
            $new_email = trim($_POST["email"]);

            // Check if email is already taken
            if($new_email !== $email){
                $check_sql = "SELECT id FROM users WHERE email = :email AND id != :id";
                $check_stmt = $pdo->prepare($check_sql);
                $check_stmt->bindParam(":email", $new_email, PDO::PARAM_STR);
                $check_stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
                $check_stmt->execute();

                if($check_stmt->rowCount() > 0){
                    $email_err = "This email is already taken.";
                } else{
                    $email = $new_email;
                }
                unset($check_stmt);
            }
        }
    }
?>