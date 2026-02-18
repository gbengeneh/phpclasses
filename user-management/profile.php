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
        // Handle profile image upload
        if(isset($_FILES["profile_image"]) && $_FILES["profile_image"]["error"] == 0){
            $allowed = ["jpg" => "image/jpeg", "jpeg" => "image/jpeg", "png" => "image/png", "gif" => "image/gif"];
            $filename = $_FILES["profile_image"]["name"];
            $filetype = $_FILES["profile_image"]["type"];
            $filesize = $_FILES["profile_image"]["size"];

            // Verify file extension
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if(!array_key_exists($ext, $allowed)){
                $profile_image_err = "Please select a valid image format(jpg, jpeg, png, gif)";
            }

            // verify file size - 5MB maximum
              if($filesize > 5 *1024 * 1024){
                $profile_image_err = "File size is larger than the allowed limit of 5MB.";
              }
            // verify MIME type of the file
            if(in_array($filetype, $allowed)){
                // check for errors before moving the file
                if(empty($profile_image_err)){
                    $newfilename = uniqid() . "." . $ext;
                    $upload_dir = "uploads/";
                    if(!is_dir($upload_dir)){
                        mkdir($upload_dir, 0755, true);
                    }
                    $destination = $upload_dir . $newfilename;
                    if(move_uploaded_file($_FILES["profile_image"]["tmp_name"], $destination)){
                        $profile_image = $destination;
                    }else{
                        $profile_image_err = "There was an error uploading your file. Please try again.";
                    }
                }
            }else{
                $profile_image_err = "Please select a valid image format(jpg, jpeg, png, gif)";
            }

        }
        // upload profile if no errors
        if(empty($firstname_err) && empty($lastname_err) && empty($username_err) && empty($email_err) && empty($profile_image_err)){
            $update_sql = "UPDATE users SET firstname = :firstname, lastname = :lastname, username = :username, email = :email, profile_image = :profile_image WHERE id = :id";
            $update_stmt = $pdo->prepare($update_sql);
            $update_stmt->bindParam(":firstname", $firstname, PDO::PARAM_STR);
            $update_stmt->bindParam(":lastname", $lastname, PDO::PARAM_STR);
            $update_stmt->bindParam(":username", $username, PDO::PARAM_STR);
            $update_stmt->bindParam(":email", $email, PDO::PARAM_STR);
            $update_stmt->bindParam(":profile_image", $profile_image, PDO::PARAM_STR);
            $update_stmt->bindParam(":id", $user_id, PDO::PARAM_INT);

            if($update_stmt->execute()){
                $_SESSION["username"] = $username; // Update session username if changed
                $update_success = "Profile updated successfully.";
            }else{
                $update_err = "There was an error updating your profile. Please try again.";
            }
            unset($update_stmt);
        }
    }
?>