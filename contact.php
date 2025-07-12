<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $date = mysqli_real_escape_string($conn, $_POST['comment_date']);
    $message = mysqli_real_escape_string($conn, $_POST['comment']);

    // ✅ Make sure your contact table has 'number' column
    $sql = "INSERT INTO contact (name, email, number, subject, comment_date, comment) 
            VALUES ('$name', '$email', '$number', '$subject', '$date', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Message sent successfully. You will be redirected to the home page shortly.</p>";
        header("refresh:5;url=home.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
