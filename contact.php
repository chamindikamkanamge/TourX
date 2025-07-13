<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and escape input data to prevent SQL injection
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $comment_date = mysqli_real_escape_string($conn, $_POST['comment_date']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    // Corrected SQL query: Match columns with values
    $sql = "INSERT INTO contact (name, email, number, subject, comment) 
            VALUES ('$name', '$email', '$number', '$subject', '$comment_date', '$comment')";

    if ($conn->query($sql) === TRUE) {
        // Success message with redirect
        echo "<p>Message sent successfully. You will be redirected to the home page shortly.</p>";
        header("refresh:5;url=home.php");
        exit(); // Ensure no further code is executed after redirect
    } else {
        // Error handling with detailed message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle non-POST requests
    echo "<p>Invalid request method. Please use the contact form.</p>";
}
?>