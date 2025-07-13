<?php
include 'config.php';

// Set error reporting (turn off in production)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set to 1 for development, 0 for production

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    $required = ['name', 'email', 'subject', 'comment'];
    $errors = [];
    
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[] = ucfirst($field) . " is required";
        }
    }
    
    // Validate email format
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    // If there are errors, display them
    if (!empty($errors)) {
        http_response_code(400); // Bad Request
        echo "<div style='padding: 20px; background: #ffeeee; border: 1px solid #ffcccc; margin: 20px;'>";
        echo "<h3>Error submitting your message:</h3>";
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
        echo "<p>Please <a href='javascript:history.back()'>go back</a> and try again.</p>";
        echo "</div>";
        exit();
    }

    // Sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $number = mysqli_real_escape_string($conn, $_POST['number'] ?? '');
    $subject = mysqli_real_escape_string($conn, $_POST['subject'] ?? '');
    $date = mysqli_real_escape_string($conn, $_POST['comment_date'] ?? date('Y-m-d H:i:s'));
    $message = mysqli_real_escape_string($conn, $_POST['comment'] ?? '');
    $rating = intval($_POST['rating'] ?? 0); // Added rating field if needed

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO contact (name, email, number, subject, comment_date, message, rating) 
                           VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    // Make sure your contact table has all these columns
    $stmt->bind_param('ssssssi', $name, $email, $number, $subject, $date, $message, $rating);

    if ($stmt->execute()) {
        // Success message with better styling
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Message Sent</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f5f5f5;
                    margin: 0;
                    padding: 0;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }
                .success-message {
                    background: white;
                    padding: 30px;
                    border-radius: 8px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    text-align: center;
                    max-width: 500px;
                    width: 90%;
                }
                .success-message h2 {
                    color: #4CAF50;
                }
                .success-message p {
                    margin: 20px 0;
                    line-height: 1.6;
                }
                .countdown {
                    font-weight: bold;
                    color: #2196F3;
                }
            </style>
        </head>
        <body>
            <div class="success-message">
                <h2>Message Sent Successfully!</h2>
                <p>Thank you for contacting us. We will get back to you soon.</p>
                <p>You will be redirected to the home page in <span class="countdown">5</span> seconds...</p>
                <p><a href="home.php">Click here</a> if you are not redirected automatically.</p>
            </div>
            <script>
                // Countdown timer
                let seconds = 5;
                const countdownEl = document.querySelector(".countdown");
                const timer = setInterval(() => {
                    seconds--;
                    countdownEl.textContent = seconds;
                    if (seconds <= 0) {
                        clearInterval(timer);
                        window.location.href = "home.php";
                    }
                }, 1000);
            </script>
        </body>
        </html>';
    } else {
        // Error handling
        http_response_code(500); // Internal Server Error
        echo "<div style='padding: 20px; background: #ffeeee; border: 1px solid #ffcccc; margin: 20px;'>";
        echo "<h3>Error submitting your message</h3>";
        echo "<p>There was a problem saving your message. Please try again later.</p>";
        echo "<p>Error: " . htmlspecialchars($stmt->error) . "</p>";
        echo "<p><a href='contact.html'>Go back to contact form</a></p>";
        echo "</div>";
    }

    $stmt->close();
    $conn->close();
    exit();
} else {
    // If someone tries to access this page directly
    header("Location: home.php");
    exit();
}