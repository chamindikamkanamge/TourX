<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reviews | TourX</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
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

<section class="review" id="review">
    <h1 class="heading"><span>r</span><span>e</span><span>v</span><span>i</span><span>e</span><span>w</span></h1>

    <div class="swiper-container review-slider">
        <div class="swiper-wrapper">
            <?php
            $sql = "SELECT * FROM reviews";
            $result = $conn->query($sql);
            $images = ['1.png', '2.png', '3.png', '4.png', '5.png', '6.png']; // Updated array with all six images
            $imageIndex = 0;

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="swiper-slide"><div class="box">';
                    // Use the next image in the array, cycling back to the start if needed
                    $currentImage = $images[$imageIndex % count($images)];
                    echo '<img src="users/' . htmlspecialchars($currentImage) . '" alt="' . htmlspecialchars($row['reviewName']) . '\'s Image" class="review-image">';
                    $imageIndex++;
                    echo '<p class="comment">' . htmlspecialchars($row['comment']) . '</p>';
                    echo '<p class="reviewName">' . htmlspecialchars($row['reviewName']) . '</p>';
                    echo '<div class="stars">';
                    $rating = $row['rating'] ?? 0;
                    for ($i = 1; $i <= 5; $i++) {
                        echo '<i class="fas fa-star' . ($i <= $rating ? ' filled' : '') . '"></i>';
                    }
                    echo '</div></div></div>';
                }
            } else {
                echo '<p>No reviews found.</p>';
            }
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    new Swiper(".review-slider", {
        loop: true,
        autoplay: { delay: 2500, disableOnInteraction: false },
        breakpoints: {
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 },
        },
        pagination: { el: '.swiper-pagination', clickable: true }
    });
</script>

<?php include 'footer.php'; ?>
</body>
</html>