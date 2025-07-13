<?php
session_start();
include 'config.php';

// ✅ Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login_user.php");
    exit();
}

// ✅ Check user type
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT usertype FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($usertype);
$stmt->fetch();
$stmt->close();

// ✅ Redirect admins to admin dashboard
if ($usertype === 'admin') {
    header("Location: admin_dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TourX - Home</title>

    <!-- Styles -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">

    <style>
        .navbar.active { display: block; }
        #menu-bar {
            cursor: pointer;
            font-size: 2rem;
            color: #333;
            display: none;
        }
        @media (max-width:768px) {
            #menu-bar { display: block; }
            .navbar {
                display: none;
                flex-direction: column;
                background: #fff;
                position: absolute;
                top: 70px;
                width: 100%;
                left: 0;
                padding: 1rem;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .navbar a { margin: 1rem 0; }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header>
        <div id="menu-bar" class="fas fa-bars"></div>
        <a href="home.php" class="logo"><span>T</span>ourX</a>

        <nav class="navbar">
            <a href="home.php">home</a>
            <a href="packages.php">packages</a>
            <a href="about_us.php">about</a>
            <a href="images.php">gallery</a>
            <a href="reviews.php">review</a>
            <a href="contact.php">contact</a>
        </nav>

       <div class="icons">
    <a href="search.php"><i class="fas fa-search" id="search-icon"></i></a>
    <a href="logout.php"><i class="fas fa-user" title="Login"></i></a>
    <a href="login_user.php"><i class="fas fa-sign-out-alt" title="Logout"></i></a>
</div>


        <form action="" class="search-bar-container">
            <input type="search" id="search-bar" placeholder="search here...">
            <label for="search-bar" class="fas fa-search"></label>
        </form>
    </header>

    <!-- Home Section -->
    <section class="home" id="home">
        <div class="content">
            <h3>Welcome </h3>
            <p>Discover new places with us, adventure awaits.</p>
            <a href="about_us.php" class="btn">Discover more</a>
        </div>
        <div class="controls">
            <span class="vid-btn active" data-src="img/vid-1.mp4"></span>
            <span class="vid-btn" data-src="img/video2.mp4"></span>
            <span class="vid-btn" data-src="img/video3.mp4"></span>
            <span class="vid-btn" data-src="img/video6.mp4"></span>
            <span class="vid-btn" data-src="img/video5.mp4"></span>
        </div>
        <div class="video-container">
            <video src="img/vid-1.mp4" id="video-slider" loop autoplay muted></video>
        </div>
    </section>

    <!-- Scripts -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const menuBar = document.getElementById('menu-bar');
            const navbar = document.querySelector('.navbar');
            menuBar.addEventListener('click', () => {
                navbar.classList.toggle('active');
            });

            const videoButtons = document.querySelectorAll('.vid-btn');
            const videoPlayer = document.getElementById('video-slider');
            videoButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const src = this.getAttribute('data-src');
                    videoPlayer.src = src;
                    videoButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    videoPlayer.play();
                });
            });

            new Swiper(".review-slider", {
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    640: { slidesPerView: 1 },
                    768: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 },
                },
            });
        });
    </script>

    <script src="script.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>
