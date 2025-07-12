<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TourX</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!--header section starts--->
    <header>
        <div id="menu-bar" class="fas fa-bars"></div>
        <a href="#" class="logo"><span>T</span>ourX</a>
        <nav class="navbar">
            <a href="#home">home</a>
            <a href="#packages">packages</a>
            <a href="#services">about</a>
            <a href="#gallery">gallery</a>
            <a href="#review">review</a>
            <a href="#contact">contact</a>
        </nav>
        <div class="icons">
            <a href="search.php"> <i class="fas fa-search" id="search-icon"></i></a>
            <a href="login_user.php"> <i class="fas fa-user" id="login-icon"></i></a>
        </div>
        <form action="" class="search-bar-container">
            <input type="search" id="search-bar" placeholder="search here...">
            <label for="search-bar" class="fas fa-search"></label>
        </form>
    </header>
    <!--header section end-->

    <!--login form container start-->
    <div class="login-form-container">
        <i class="fas fa-times" id="form-close"></i>
        <form action="">
            <h3>login</h3>
            <input type="email" class="box" placeholder="enter your email">
            <input type="password" class="box" placeholder="enter your password">
            <input type="submit" value="login now" class="btn">
            <input type="checkbox" id="remember">
            <label for="remember">remember me</label>
            <p>forget password? <a href="#">click here</a></p>
            <p>don't have an account? <a href="#">register now</a></p>
        </form>
    </div>
    <!--login form container end-->

    <!--admin login form container start-->
    <div class="login-form-container">
        <form action="admin_login.php" method="POST">
            <h3>Admin Login</h3>
            <input type="text" name="username" class="box" placeholder="enter your username" required>
            <input type="password" name="password" class="box" placeholder="enter your password" required>
            <input type="submit" name="login" value="login now" class="btn">
        </form>
    </div>
    <!--admin login form container end-->

    <!--home section start-->
    <section class="home" id="home">
        <div class="content">
            <h3>adventure is worthwhile</h3>
            <p>discover new places with us, adventure awaits</p>
            <a href="https://en.wikipedia.org/wiki/Tourism_in_Sri_Lanka" class="btn">discover more</a>
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
    <!--home section end-->
    <section class="packages" id="packages">
    <h1 class="heading">
        <span>p</span>
        <span>a</span>
        <span>c</span>
        <span>k</span>
        <span>a</span>
        <span>g</span>
        <span>e</span>
        <span>s</span>
    </h1>

    <div class="box-container" style="display: flex; flex-wrap: wrap; gap: 2rem; justify-content: center; font-size:1.4rem;">
        <?php
            include 'config.php';

            $sql = "SELECT * FROM packages"; 
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="box" style="flex: 1; max-width: 300px; padding: 2rem; border: 1px solid #ccc;">';
                    echo '<img src="uploads/' . $row['image'] . '" alt="' . $row['name'] . '" style="max-width: 100%; max-height: 250px;">';
                    echo '<div class="content">';
                    echo '<h3><i class="fas fa-map-marker-alt"></i> ' . $row['name'] . '</h3>';
                    echo '<p>' . $row['description'] . '</p>';
                    echo '<div class="stars">';

                    
                    // Displaying the rating
                    $rating = isset($row['rating']) ? $row['rating'] : 0;
                    for ($i = 1; $i <= 5; $i++) {
                        echo '<i class="fas fa-star';
                        if ($i <= $rating) {
                            echo ' filled';
                        }
                        echo '"></i>'; // filled or empty star
                    }

                    echo '</div>';
                    echo '<div class="price">LKR.' . $row['price'] . '<span>LKR.19000</span></div>';
                    
                    // Form for booking
                    echo '<form action="book.php" method="POST">';
                    echo '<input type="hidden" name="package_id" value="' . $row['id'] . '">';
                    echo '<button type="submit" class="btn" style="justify-content: center; align-items: center;">Book Now</button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No packages found</p>';
            }

            $conn->close();
        ?>
    </div>
</section>

<!--packages section end-->

    <!--services section start-->
    <section class="services" id="services">
    <h1 class="heading">
        <span>a</span>
        <span>b</span>
        <span>o</span>
        <span>u</span>
        <span>t</span>
    </h1>
    
    <div class="box-container">
        <div class="box">
           
            <h2><p>"Welcome to TOUR X, where dreams meet reality. We offer a wide range of curated travel experiences, catering to various interests and budgets. Our team simplifies trip planning, from booking flights and hotels to arranging activities. We're also committed to sustainable tourism, ensuring future generations can enjoy our world's beauty. Start your adventure with us today!"</p></h2>
        </div>
    </div>
</section>
<!--services section end--> 

    <!--gallery section start-->
    <section class="gallery" id="gallery">
        <h1 class="heading">
            <span>g</span>
            <span>a</span>
            <span>l</span>
            <span>l</span>
            <span>e</span>
            <span>r</span>
            <span>y</span>
        </h1>
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="box-container">
                    <div class="box">


                        <img src="img/1.png" alt="">
                        <div class="content">
                            <h3>amazing places</h3>
                            <p>"Embark on unforgettable journeys with TourX. Explore serene landscapes, immerse in vibrant cultures."</p>
                            <a href="gallery.php" class="btn">see more</a>
                        </div>
                    </div>
                    <div class="box">
                        <img src="img/10.png" alt="">
                        <div class="content">
                            <h3>amazing places</h3>
                            <p>"Embark on unforgettable journeys with TourX. Explore serene landscapes, immerse in vibrant cultures."</p>
                            <a href="gallery.php" class="btn">see more</a>
                        </div>
                    </div>
                    <div class="box">
                        <img src="img/11.png" alt="">
                        <div class="content">
                            <h3>amazing places</h3>
                            <p>"Embark on unforgettable journeys with TourX. Explore serene landscapes, immerse in vibrant cultures."</p>
                            <a href="#" class="btn">see more</a>
                        </div>
                    </div>
                    <div class="box">
                        <img src="img/2.png" alt="">
                        <div class="content">
                            <h3>amazing places</h3>
                            <p>"Embark on unforgettable journeys with TourX. Explore serene landscapes, immerse in vibrant cultures."</p>
                            <a href="gallery.php" class="btn">see more</a>
                        </div>
                    </div>
                    <div class="box">
                        <img src="img/3.png" alt="">
                        <div class="content">
                            <h3>amazing places</h3>
                            <p>"Embark on unforgettable journeys with TourX. Explore serene landscapes, immerse in vibrant cultures."</p>
                            <a href="gallery.php" class="btn">see more</a>
                        </div>
                    </div>
                    <div class="box">
                        <img src="img/6.png" alt="">
                        <div class="content">
                            <h3>amazing places</h3>
                            <p>"Embark on unforgettable journeys with TourX. Explore serene landscapes, immerse in vibrant cultures."</p>
                            <a href="gallery.php" class="btn">see more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--gallery section end-->

 <!-- review section start -->
<section class="review" id="review">
    <h1 class="heading">
        <span>r</span><span>e</span><span>v</span><span>i</span><span>e</span><span>w</span>
    </h1>

    <div class="swiper-container review-slider">
        <div class="swiper-wrapper">
            <?php
            // Database connection
            include 'config.php';

            // Query to get reviews
            $review_sql = "SELECT * FROM reviews";
            $review_result = $conn->query($review_sql);

            // Query to get contact information
            $contact_sql = "SELECT * FROM contact";
            $contact_result = $conn->query($contact_sql);

            // Display reviews
            if ($review_result->num_rows > 0) {
                while ($review_row = $review_result->fetch_assoc()) {
                    echo '<div class="swiper-slide">';
                    echo '<div class="box">';
                    echo '<p>' . $review_row['rdate'] . '</p><br>';
                    echo '<p class="comment">' . $review_row['comment'] . '</p><br>';
                    echo '<p class="reviewName">' . $review_row['reviewName'] . '</p>';
                    
                    echo '<div class="content">';
                    echo '<div class="stars">';

                    // Generate star rating based on the 'rating' field
                    $rating = isset($review_row['rating']) ? $review_row['rating'] : 0;
                    for ($i = 1; $i <= 5; $i++) {
                        echo '<i class="fas fa-star';
                        if ($i <= $rating) {
                            echo ' filled';
                        }
                        echo '"></i>'; // filled or empty star
                    }

                    echo '</div>'; // stars
                    echo '</div>'; // content
                    echo '</div>'; // box
                    echo '</div>'; // swiper-slide
                }
            } else {
                echo '<div class="swiper-slide">';
                echo '<p>No reviews found</p>';
                echo '</div>';
            }

            // Display contact information
            if ($contact_result->num_rows > 0) {
                while ($contact_row = $contact_result->fetch_assoc()) {
                    echo '<div class="swiper-slide">';
                    echo '<div class="box">';
                    echo '<p> ' . $contact_row['comment'] . '</p>';
                    echo '<p> ' . $contact_row['comment_date'] . '</p>';
                    echo '<p> ' . $contact_row['name'] . '</p>';
                    echo '</div>'; // box
                    echo '</div>'; // swiper-slide
                }
            } else {
                echo '<div class="swiper-slide">';
                echo '<p> </p>';
                echo '</div>';
            }

            // Close connection
            $conn->close();
            ?>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
        <!-- Add Navigation Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</section>




<style>
    /* Add or modify styles as needed */
    .review .contact-info {
        margin-top: 10px;
    }

    .review .contact-info p {
        margin-bottom: 5px;
    }
</style>

    <!--contact section start-->
    <section class="contact" id="contact">
        <h1 class="heading">
            <span>c</span>
            <span>o</span>
            <span>n</span>
            <span>t</span>
            <span>a</span>
            <span>c</span>
            <span>t</span>
        </h1>

        <div class="row">
            <div class="image">
                <img src="img/contact-img.svg" alt="">
            </div>
            <form action="contact.php" method="POST">
                <div class="inputBox">
                    <input type="text" name="name" placeholder="name" required>
                    <input type="email" name="email" placeholder="email" required>
                </div>
                <div class="inputBox">
                    <input type="number" name="number" placeholder="number" required>
                    <input type="text" name="subject" placeholder="subject" required>
                </div>

                <div class="inputBox">
                   
                    <input type="date" name="comment_date">
                </div>

                <textarea placeholder="comment" name="comment" id="" cols="10" rows="2" required></textarea>
                <input type="submit" class="btn" value="send message">
            </form>
        </div>
    </section>
    <!--contact section end-->



    <!--footer section start-->
    <section class="footer">
        <div class="box-container">
            <div class="box">
                <h3>about us</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit optio eos ab aliquam doloremque eaque?</p>
            </div>
            <div class="box">
                <h3>branch locations</h3>
                <a href="#">sri lanka</a>
                <a href="#">USA</a>
                <a href="#">india</a>
                <a href="#">japan</a>
            </div>
            <div class="box">
                <h3>quick links</h3>
                <a href="#">home</a>
                <a href="#">packages</a>
                <a href="#">about</a>
                <a href="#">gallery</a>
                <a href="#">review</a>
                <a href="#">contact</a>
            </div>
            <div class="box">
                <h3>follow us</h3>
                <a href="#">facebook</a>
                <a href="#">instagram</a>
                <a href="#">twitter</a>
                <a href="#">linkedin</a>
            </div>
        </div>
        <h1 class="credit">created by <span>TourX</span> | all rights reserved</h1>
    </section>
    <!--footer section end-->

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            new Swiper(".review-slider", {
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                    },
                    768: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
            });


            new Swiper(".brand-slider", {
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                    },
                    768: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
            });


            var menuBar = document.getElementById('menu-bar');
            var menu = document.querySelector('.menu');
            menuBar.addEventListener('click', function() {
                menu.classList.toggle('active');
            });


            const videoButtons = document.querySelectorAll('.vid-btn');
            const videoPlayer = document.getElementById('video-slider');
            videoButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const src = this.getAttribute('data-src');
                    videoPlayer.src = src;
                    videoButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    videoPlayer.play();
                });
            });


            let searchBtn = document.querySelector('#search-btn');
            let searchBar = document.querySelector('.search-bar-container');
            searchBtn.addEventListener('click', () => {
                searchBtn.classList.toggle('fa-times');
                searchBar.classList.toggle('active');
            });
        });
    </script>


    <script src="script.js"></script>
</body>

</html>
</body>

</html>