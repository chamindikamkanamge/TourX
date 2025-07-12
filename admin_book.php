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

// Fetch data from the book table
$sql = "SELECT * FROM book";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Booking Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .admin-panel {
            width: 80%;
            margin: auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .heading {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .orders {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <section class="admin-panel">
        <h1 class="heading">Booking Orders</h1>
        <div class="orders">
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Where To</th>
                        <th>How Many</th>
                        <th>Arrivals Date</th>
                        <th>Leaving Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["username"] . "</td>
                                    <td>" . $row["where_to"] . "</td>
                                    <td>" . $row["how_many"] . "</td>
                                    <td>" . $row["arrivals_date"] . "</td>
                                    <td>" . $row["leaving_date"] . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No bookings found</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>
