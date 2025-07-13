<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gallery | TourX</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .gallery .box-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .gallery .box {
            border-radius: 10px;
            overflow: hidden;
            background: #f9f9f9;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            text-align: center;
            padding: 10px;
        }

        .gallery .box img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border: 3px solid #333;
            border-radius: 10px;
        }

        .gallery .box .content {
            padding: 10px;
        }

        .gallery .box .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .gallery .box .btn:hover {
            background-color: #0056b3;
        }
    </style>
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

<section class="gallery" id="gallery">
    <h1 class="heading"><span>g</span><span>a</span><span>l</span><span>l</span><span>e</span><span>r</span><span>y</span></h1>
    <div class="box-container">
        <?php
        $images = ['img/1.png', 'img/2.png', 'img/3.png', 'img/10.png', 'img/11.png', 'img/6.png'];

        foreach ($images as $img) {
            echo '<div class="box">';
            echo '<img src="' . $img . '" alt="gallery">';
            echo '<div class="content">';
            echo '<h3>amazing places</h3>';
            
            echo '<a href="gallery.php?image=' . urlencode($img) . '" class="btn">See More</a>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
