<?php 
  session_start();
  if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
  }

  require_once 'config/database.php';

//   get user information
 $user_id = $_SESSION["id"];
 $sql = "SELECT firstname, lastname, username, email, created_at, profile_image FROM users WHERE id = :id";
 $stmt = $pdo->prepare($sql);
 $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
 $stmt->execute();
    $user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <div class="header">
        <h3>Welcome <?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?></h3>
        <div class="nav">
            <a href="profile.php" class="btn">My Profile</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <div class="dashboard-content">
        <div class="user-info">
            <h4>User Information</h4>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($user['firstname']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user['lastname']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Member Since:</strong> <?php echo date("F j, Y", strtotime($user['created_at'])); ?></p>
            <?php if(!empty($user['profile_image'])): ?>
                <div class="profile-image">
                    <img src="<?php echo htmlspecialchars($user['profile_image']); ?>" alt="Profile Image"style="width:150px;height:150px;border-radius:50%;object-fit:cover;">
                </div>
            <!-- <?php endif; ?> -->
        </div>

        <div class="quick-actions">
            <h3>Quick Actions</h3>
            <div class="action-buttons">
                <a href="profile.php" class="btn">Edit Profile</a>
                <a href="change_password.php" class="btn">Change Password</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>
    </div>
</body>
</html>