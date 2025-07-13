<?php
session_start();
session_unset();
session_destroy();
header("Location: login_user.php");  // Redirect to login page after logout
exit();
?>
