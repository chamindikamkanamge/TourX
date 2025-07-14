<?php
session_start();

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["Username"]) && isset($_POST["Password"])) {
        $username = trim($_POST["Username"]);
        $password = trim($_POST["Password"]);
        
        // Prepare and bind
        $stmt = $conn->prepare("SELECT usertype, username, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($usertype, $db_username, $db_password);
            $stmt->fetch();

            // Debug: Log fetched values
            error_log("DB Username: $db_username");
            error_log("DB Password: $db_password");

            // Verify the password
            if ($password === $db_password && $usertype=='user') {
                // Password is correct, set the session and redirect to home.php
                $_SESSION['username'] = $db_username;
                header("Location:home.php");
                exit();
            }
            else if($password === $db_password && $usertype == 'admin'){
                $_SESSION['username'] = $db_username;
                header("Location: admin_dashboard.php");
                exit();
            }
            else {
                // Password is incorrect
                echo "<script>alert('Invalid username or password');</script>";
            }
        } else {
            // Username not found
            echo "<script>alert('Invalid username or password');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Please provide both username and password');</script>";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    
    <link rel="stylesheet" href="css/login.css">
    <script type="text/javascript" src="js/login.js"></script>
</head>
<body>
    <div class="bg-img" style="background-image: url('uploads/55.jpg');">
        <div class="center">
            <h1>Login</h1>
            <form id="loginForm" name="loginForm" onsubmit="return validateForm()" method="POST" action="">
                <div class="txt-field">
                    <input type="text" name="Username" id="Username">
                    <span></span>
                    <label>Username</label>
                </div>
                <div class="txt-field">
                    <input type="password" name="Password" id="Password">
                    <span></span>
                    <label>Password</label>
                </div>  
                <div class="pass"><a href="UpdatePassword.php">Forgot Password?</a></div>
                <input type="submit" value="Login">
                <div class="sign-up_link">
                    Not a Member? <a href="sign.php">Sign Up </a>
                </div>
                
            </form>
        </div>
    </div>
    <script>
        function validateForm() {
            var username = document.getElementById("Username").value;
            var password = document.getElementById("Password").value;

            if (username.trim() === "") {
                alert("Please enter your username.");
                return false;
            }

            if (password.length < 4) {
                alert("Password must be at least 4 characters long");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
