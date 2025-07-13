<?php include 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Packages | TourX</title>
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
    <!-- Custom style for layout and image frame -->
    <style>
        .packages .box-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* Four columns */
            gap: 20px;
            padding: 20px;
        }

        .packages .box {
            background: #f9f9f9;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .packages .box:hover {
            transform: translateY(-5px);
        }

        .packages .box img {
            border: 4px solid #333;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            padding: 3px;
            max-height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .packages .content {
            padding: 15px;
        }

        .packages .price {
            font-weight: bold;
            margin-top: 10px;
            color: #007bff;
        }

        .btn {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 8px 15px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn:hover {
            background: #218838;
        }

        .heading {
            text-align: center;
            margin: 20px 0;
        }

        @media (max-width: 1200px) {
            .packages .box-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .packages .box-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 500px) {
            .packages .box-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

<?php include 'header.php'; ?>

<section class="packages" id="packages">
    

    <div class="box-container">
        <?php
        $sql = "SELECT * FROM packages";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="box">';
                echo '<img src="uploads/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                echo '<div class="content">';
                echo '<h3><i class="fas fa-map-marker-alt"></i> ' . htmlspecialchars($row['name']) . '</h3>';
                echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                echo '<div class="stars">';
                $rating = $row['rating'] ?? 0;
                for ($i = 1; $i <= 5; $i++) {
                    echo '<i class="fas fa-star' . ($i <= $rating ? ' filled' : '') . '"></i>';
                }
                echo '</div>';
                echo '<div class="price">LKR. ' . htmlspecialchars($row['price']) . '</div>';
                echo '<form action="book.php" method="POST">';
                echo '<input type="hidden" name="package_id" value="' . $row['id'] . '">';
                echo '<button type="submit" class="btn">Book Now</button>';
                echo '</form>';
                echo '</div></div>';
            }
        } else {
            echo '<p>No packages found.</p>';
        }

        $conn->close();
        ?>
    </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
