<?php include 'config.php'; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $number = mysqli_real_escape_string($conn, $_POST["number"]);
    $subject = mysqli_real_escape_string($conn, $_POST["subject"]);
    $date = mysqli_real_escape_string($conn, $_POST["date"]);
    $comment = mysqli_real_escape_string($conn, $_POST["comment"]);

    $sql = "INSERT INTO contact (name, email, number, subject, date, comment) 
            VALUES ('$name', '$email', '$number', '$subject', '$date', '$comment')";

    if ($conn->query($sql)) {
        $msg = "Message sent successfully!";
    } else {
        $msg = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact | TourX</title>
    <link rel="stylesheet" href="css/styles.css">
    <nav class="navbar">
    <a href="home.php">home</a>
    <a href="packages.php">packages</a>
    <a href="about_us.php">about</a>
    <a href="images.php">gallery</a> <!-- ✅ Fixed -->
    <a href="reviews.php">review</a>
    <a href="contact.php">contact</a>
</nav>

        <div class="icons">
            <a href="search.php"><i class="fas fa-search" id="search-icon"></i></a>
            <a href="login_user.php"><i class="fas fa-user" id="login-icon"></i></a>
        </div>

        <form action="" class="search-bar-container">
            <input type="search" id="search-bar" placeholder="search here...">
            <label for="search-bar" class="fas fa-search"></label>
        </form>
</head>
<body>

<?php include 'header.php'; ?>

<section class="contact" id="contact">
    <h1 class="heading"><span>c</span><span>o</span><span>n</span><span>t</span><span>a</span><span>c</span><span>t</span></h1>
    <div class="row">
        <div class="image">
            <img src="img/contact-img.svg" alt="">
        </div>
        <form method="POST" action="">
            <div class="inputBox">
                <input type="text" name="name" placeholder="name" required>
                <input type="email" name="email" placeholder="email" required>
            </div>
            <div class="inputBox">
                <input type="number" name="number" placeholder="number" required>
                <input type="text" name="subject" placeholder="subject" required>
            </div>
            <div class="inputBox">
                <input type="date" name="date">
            </div>
            <textarea name="comment" placeholder="comment" cols="10" rows="3" required></textarea>
            <input type="submit" value="send message" class="btn">
            <?php if (!empty($msg)) echo "<p>$msg</p>"; ?>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
