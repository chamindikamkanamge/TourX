<?php
include 'config.php';  // Include your database configuration file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "update";   

    // Get and sanitize input
    $email = htmlspecialchars(trim($_POST["Email"]));
    $newPassword = htmlspecialchars(trim($_POST["UpdatePassword"]));
    $confirmPassword = htmlspecialchars(trim($_POST["ConfirmPassword"]));

    // Check if passwords match
    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.'); window.location.href = 'updateForm.php';</script>";
        exit;
    }

    // No hashing: store password as plain text directly
    $plainPassword = $newPassword;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $plainPassword, $email);

        // Execute statement
        if ($stmt->execute()) {
            echo "<script>alert('Password updated successfully!'); window.location.href = 'login_user.php';</script>";
        } else {
            echo "<script>alert('Error updating password: " . htmlspecialchars($stmt->error) . "'); window.location.href = 'updateForm.php';</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Database error: " . htmlspecialchars($conn->error) . "'); window.location.href = 'updateForm.php';</script>";
    }

    $conn->close();
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Password</title>
  <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
  <div class="bg-img">
    <div class="center">
      <h1>Update Password</h1>

      <!-- ✅ FIX: Added proper form tag -->
      <form method="POST" action="" onsubmit="return validateForm();">
        <div class="txt-field">
          <input type="text" name="Email" id="Email" required>
          <span></span>
          <label>Email</label>
        </div>
        <div class="txt-field">
          <input type="password" name="UpdatePassword" id="UpdatePassword" required>
          <span></span>
          <label>New Password</label>
        </div>
        <div class="txt-field">
          <input type="password" name="ConfirmPassword" id="ConfirmPassword" required>
          <span></span>
          <label>Confirm New Password</label>
        </div>  
        <br>
        <input type="submit" value="Update">
        <div class="sign-up_link">
          <a href="login_user.php">Back to Login</a>
        </div>
      </form>
    </div>
  </div>

  <script>
    function validateForm() {
      const email = document.getElementById('Email').value.trim();
      const newPassword = document.getElementById('UpdatePassword').value;
      const confirmPassword = document.getElementById('ConfirmPassword').value;

      if (newPassword !== confirmPassword) {
        alert('Passwords do not match.');
        return false;
      }

      if (email === "" || newPassword === "" || confirmPassword === "") {
        alert('Please fill in all fields.');
        return false;
      }

      // Add more validation rules as needed

      return true;
    }
  </script>
</body>
</html>
