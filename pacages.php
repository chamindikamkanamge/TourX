<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <a href="#home"><title>TourX</title></a>
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
            <a href="home.php">home</a>
            <a href="pacages.php">packages</a>
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

</html>

<!--packages section end-->