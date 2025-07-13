<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input data
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $number = trim($_POST['number'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $comment_date = trim($_POST['comment_date'] ?? '');
    $comment = trim($_POST['comment'] ?? '');

    // Basic validation
    if (empty($name) || empty($email) || empty($number) || empty($subject) || empty($comment_date) || empty($comment)) {
        echo "<p>Error: All fields are required. Please fill out the form completely.</p>";
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p>Error: Invalid email format.</p>";
        exit();
    }

    // Validate comment_date format (assuming YYYY-MM-DD HH:MM:SS)
    if (!preg_match("/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/", $comment_date)) {
        echo "<p>Error: Invalid date format for comment_date.</p>";
        exit();
    }

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("INSERT INTO contact (name, email, number, subject, comment_date, comment) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }

    $stmt->bind_param("ssssss", $name, $email, $number, $subject, $comment_date, $comment);

    // Execute the query
    if ($stmt->execute()) {
        echo "<p>Message sent successfully. You will be redirected to the home page in 5 seconds.</p>";
        header("refresh:5;url=home.php");
        exit();
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "<p>Invalid request method. Please use the contact form.</p>";
}
?>