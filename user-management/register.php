<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Register</title>
</head>

<body>
    <div class="container">
        <h2>Register</h2>
        <p>Please fill this form to create an account.</p>
        <!-- register error goes-->
        <form action="">
            <div class="form-group">
                <label for=""> First Name</label>
                <input type="text" name="firstname" value="">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label for="">Last Name</label>
                <input type="text" name="lastname" value="">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label for="">Username</label>
                <input type="text" name="username" value="">
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input type="text" name="email" value="">
                <span class="help-block"></span>
            </div>

            <div class="form-group">
                <label for="">Password</label>
                <div class="password-wrapper">
                    <input type="password" id="password" name="password" value="">
                    <span class="toggle-password" onclick="togglePassword">&#128065</span>
                </div>
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label for="">Confirm Password</label>
                <div class="password-wrapper">
                <input type="password" id="confirm_password" name="confirm_password" value="">
                <span class="toggle-password" onclick="togglePassword">&#128065</span>
                </div>
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Register">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
    <script>
        function togglePassword(id){
            var input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>

</html>