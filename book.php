<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "update";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$Username = $where_to = $how_many = $arrivals_date = $leaving_date = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get POST data
    $Username = isset($_POST["username"]) ? $_POST["username"] : "";
    $where_to = isset($_POST["where_to"]) ? $_POST["where_to"] : "";
    $how_many = isset($_POST["how_many"]) ? $_POST["how_many"] : "";
    $arrivals_date = isset($_POST["arrivals_date"]) ? $_POST["arrivals_date"] : "";
    $leaving_date = isset($_POST["leaving_date"]) ? $_POST["leaving_date"] : "";

    // Validate data
    if (!empty($Username) && !empty($where_to) && !empty($how_many) && !empty($arrivals_date) && !empty($leaving_date)) {
        // Prepare insert query
        $sql = "INSERT INTO book (username, where_to, how_many, arrivals_date, leaving_date) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssiss", $Username, $where_to, $how_many, $arrivals_date, $leaving_date);
            if ($stmt->execute()) {
                // Show popup message and redirect
                echo "<script>alert('Booking submitted successfully!'); window.location.href='home.php';</script>";
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }
}

// Fetch bookings for display
$bookings = [];
$sql = "SELECT * FROM book WHERE username = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $Username);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookings = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TourX - Book Now</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- Book Section Start -->
    <section class="book" id="book">
        <h1 class="heading">
            <span>b</span><span>o</span><span>o</span><span>k</span>
            <span class="space"></span>
            <span>n</span><span>o</span><span>w</span>
        </h1>

        <div class="row">
            <div class="image">
                <img src="book-img.svg" alt="Booking image">
            </div>
            <form id="bookForm" name="book" onsubmit="return validateForm()" method="POST" action="book.php">
                <div class="inputBox">
                    <h3>name</h3>
                    <input type="text" name="username" placeholder="username" required>
                </div>
                <div class="inputBox">
                    <h3>where to</h3>
                    <input type="text" name="where_to" placeholder="place name" required>
                </div>
                <div class="inputBox">
                    <h3>how many</h3>
                    <input type="number" name="how_many" placeholder="number of guests" required>
                </div>
                <div class="inputBox">
                    <h3>arrivals</h3>
                    <input type="date" name="arrivals_date" required>
                </div>
                <div class="inputBox">
                    <h3>leaving</h3>
                    <input type="date" name="leaving_date" required>
                </div>
                <input type="submit" class="btn" value="book now">
            </form>
        </div>

        <!-- Booked Packages Display -->
        <?php if (!empty($bookings)): ?>
            <h2>Booked Packages</h2>
            <table border="1" cellpadding="8" cellspacing="0">
                <tr>
                    <th>Username</th>
                    <th>Where To</th>
                    <th>How Many</th>
                    <th>Arrivals Date</th>
                    <th>Leaving Date</th>
                </tr>
                <?php foreach($bookings as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["username"]); ?></td>
                        <td><?php echo htmlspecialchars($row["where_to"]); ?></td>
                        <td><?php echo htmlspecialchars($row["how_many"]); ?></td>
                        <td><?php echo htmlspecialchars($row["arrivals_date"]); ?></td>
                        <td><?php echo htmlspecialchars($row["leaving_date"]); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No bookings found.</p>
        <?php endif; ?>
    </section>
    <!-- Book Section End -->

    <script>
        function validateForm() {
            var form = document.forms["book"];
            var username = form["username"].value.trim();
            var where_to = form["where_to"].value.trim();
            var how_many = form["how_many"].value;
            var arrivals = form["arrivals_date"].value;
            var leaving = form["leaving_date"].value;

            if (!username || !where_to || !how_many || !arrivals || !leaving) {
                alert("All fields must be filled out.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
