<?php
session_start();

// Include the database configuration file
include 'config.php';

// Define variables and initialize with empty values
$username = $password = $confirm_password = $email = "";
$username_err = $password_err = $confirm_password_err = $email_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $username_err = "This username is already taken.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email address.";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email address.";
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 4) {
        $password_err = "Password must have at least 4 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before inserting into database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {
        $usertype = "admin";
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, email,usertype) VALUES (?, ?, ?,?)";

        if ($stmt = $conn->prepare($sql)) {

            // Set parameters
            $param_username = $username;
            $param_password = $password; // Hash the password
            $param_email = $email;
            $param_usertype = $usertype;

            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ssss", $param_username, $param_password, $param_email, $usertype);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Redirect to login page
                header("location:login_user.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register</title>
    <link rel="stylesheet" href="css/login.css">
    <script type="text/javascript" src="js/login.js"></script>
</head>

<body>
    <div class="bg-img" style="background-image: url('uploads/55.jpg');">
        <div class="center">
            <h1>Admin Register</h1>
            <form id="registerForm" name="registerForm" onsubmit="return validateRegisterForm()" method="POST" action="admin_register.php">
                <div class="txt-field">
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>">
                    <span></span>
                    <label>Username</label>
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                <div class="txt-field">
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>">
                    <span></span>
                    <label>Email</label>
                    <span class="help-block"><?php echo $email_err; ?></span>
                </div>
                <div class="txt-field">
                    <input type="password" name="password" id="password" value="<?php echo htmlspecialchars($password); ?>">
                    <span></span>
                    <label>Password</label>
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="txt-field">
                    <input type="password" name="confirm_password" id="confirm_password" value="<?php echo htmlspecialchars($confirm_password); ?>">
                    <span></span>
                    <label>Confirm Password</label>
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                <input type="submit" value="Register">
                <p>Already have an account <a href="login_user.php">Login</a> </p>
                <p>back to <a href="home.php">Home</a> </p>

            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            var username = document.getElementById('Username').value;
            var password = document.getElementById('Password').value;

            if (username == "" || password == "") {
                alert("Please fill in all fields.");
                return false;
            }
            return true;
        }

        function validateRegisterForm() {
            var username = document.getElementById('username').value;
            var password = document.getElementById('password').value;
            var confirm_password = document.getElementById('confirm_password').value;
            var email = document.getElementById('email').value;

            if (username == "" || password == "" || confirm_password == "" || email == "") {
                alert("Please fill in all fields.");
                return false;
            }

            if (password != confirm_password) {
                alert("Passwords do not match.");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>