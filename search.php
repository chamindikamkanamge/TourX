<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Page</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body> 
    <div class="bg-img" style="background-image: url('img/2.png');">
        <div class="heading">
            <h3>Search Page</h3>
            <p> <a href="home.php">Home</a> / Search </p>
        </div>

        <section class="search-form">
            <form action="search.php" method="post">
                <input type="text" name="search" placeholder="Search packages..." class="box">
                <input type="submit" name="submit" value="Search" class="btn">
            </form>
        </section>

        <section class="products" style="padding-top: 0;">
            <div class="box-container" style="font-size:1.5rem;">
                <?php
                include 'config.php';

                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
                    $searchTerm = trim($_POST['search']);
                    
                    if (!empty($searchTerm)) {
                        $searchTerm = '%' . $searchTerm . '%';
                        $sql = "SELECT * FROM packages WHERE name LIKE ? OR description LIKE ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param('ss', $searchTerm, $searchTerm);
                    } else {
                        $sql = "SELECT * FROM packages";
                        $stmt = $conn->prepare($sql);
                    }
                    
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="box">';
                            echo '<img src="uploads/' . $row['image'] . '" alt="' . $row['name'] . '" style="max-width: 200px; max-height:300px;">';
                            echo '<div class="content">';
                            echo '<h3>' . $row['name'] . '</h3>';
                            echo '<p>' . $row['description'] . '</p>';
                            echo '<p>Price: LKR.' . $row['price'] . '</p>'; // Displaying the price here
                            // Book Now button with onclick event to redirect
                            echo '<button class="btn" onclick="redirectToBookPage(' . $row['id'] . ')">Book Now</button>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No packages found</p>';
                    }
                    
                    $stmt->close();
                    $conn->close();
                }
                ?>
            </div>
        </section>
    </div>

    <script>
        function redirectToBookPage(packageId) {
            // Redirect to book.php with package_id as query parameter
            window.location.href = 'book.php?package_id=' + packageId;
        }
    </script>
</body>
</html>
