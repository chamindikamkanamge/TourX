<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "update";

    // Get form data
    $Username = trim($_POST["username"]);
    $Email = trim($_POST["email"]);
    $Password = $_POST["password"];
    $ConfirmPassword = $_POST["confirmPassword"];

    // Validate form data
    $errors = [];
    if (empty($Username)) {
        $errors[] = "Username is required";
    }
    if (empty($Email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($Password)) {
        $errors[] = "Password is required";
    } elseif (strlen($Password) < 5) {
        $errors[] = "Password must be at least 5 characters long";
    } elseif ($Password !== $ConfirmPassword) {
        $errors[] = "Passwords do not match";
    }

    // If there are no errors, proceed with registration
    if (empty($errors)) {
        // Create connection
        $conn = new mysqli($servername, $db_username, $db_password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind
        $usertype = "user"; 
        $stmt = $conn->prepare("INSERT INTO users (Username, Email, Password,Usertype) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $Username, $Email, $Password, $usertype);

        if ($stmt->execute()) {
            header("Location: login_user.php"); 

            
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="login.css">
    <script type="text/javascript" src="signupValidation.js"></script>
</head>
<body>
    <div class="bg-img" style="background-image: url('pexels-krivec-ales-547114.jpg');">
        <div class="center">
            <form id="SignUpForm" name="SignUpForm" onsubmit="return validateForm()" method="POST" action="">
                <h1>Sign Up</h1>
                <p>Please fill in this form to create an account.</p>
                <div class="txt-field">
                    <input type="text" id="username" name="username">
                    <span></span>
                    <label>Username</label>
                </div>
                
                <div class="txt-field">
                    <input type="email" id="email" name="email">
                    <span></span>
                    <label>Email</label>
                </div>
                <div class="txt-field">
                    <input type="password" id="password" name="password">
                    <span></span>
                    <label>Password</label>
                </div>
                <div class="txt-field">
                    <input type="password" id="confirmPassword" name="confirmPassword">
                    <span></span>
                    <label>Repeat Password</label>
                </div>
                <input type="submit" value="Signup">
            </form>

            <div class="sign-up_link">
                <p>Already have an account? <a href="login_user.php">Login</a></p>
            </div>
        </div>
    </div>

    <script>
        function validateForm() {
            var username = document.getElementById("username").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirmPassword").value;

            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (username.trim() === "") {
                alert("Please enter your username.");
                return false;
            }

            if (!email.match(emailPattern)) {
                alert("Please enter a valid email address.");
                return false;
            }

            if (password.length < 4) {
                alert("Password must be at least 4 characters long.");
                return false;
            }

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
