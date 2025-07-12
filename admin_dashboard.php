<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit();
}

// -------------------- Handle PACKAGE actions --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['package_action'])) {
    $action = $_POST['package_action'];
    $pname  = mysqli_real_escape_string($conn, $_POST['package_name'] ?? '');
    $price  = floatval($_POST['package_price'] ?? 0);
    $pdesc  = mysqli_real_escape_string($conn, $_POST['package_description'] ?? '');
    $pid    = intval($_POST['package_id'] ?? 0);
    $image  = '';

    // Handle image upload if provided
    if (!empty($_FILES['package_image']['name'])) {
        $uploadDir  = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $image = basename($_FILES['package_image']['name']);
        $target = $uploadDir . $image;
        move_uploaded_file($_FILES['package_image']['tmp_name'], $target);
    } else {
        // If update and no new image uploaded, keep existing
        $image = $_POST['existing_image'] ?? '';
    }

    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO packages (name, price, description, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('sdss', $pname, $price, $pdesc, $image);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'update') {
        $stmt = $conn->prepare("UPDATE packages SET name=?, price=?, description=?, image=? WHERE id=?");
        $stmt->bind_param('sdssi', $pname, $price, $pdesc, $image, $pid);
        $stmt->execute();
        $stmt->close();
    } elseif ($action === 'delete') {
        // Optionally delete image file here if you want
        $stmt = $conn->prepare("DELETE FROM packages WHERE id=?");
        $stmt->bind_param('i', $pid);
        $stmt->execute();
        $stmt->close();
    }
}

// -------------------- Handle REVIEW actions --------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['review_action'])) {
    $name = mysqli_real_escape_string($conn, $_POST['review_name'] ?? '');
    $comment = mysqli_real_escape_string($conn, $_POST['review_comment'] ?? '');
    $reviewId = intval($_POST['review_id'] ?? 0);
    $current_date = date('Y-m-d');

    if ($_POST['review_action'] === 'add') {
        $conn->query("INSERT INTO reviews (reviewName, comment, rdate) VALUES ('$name', '$comment', '$current_date')");
    } elseif ($_POST['review_action'] === 'delete') {
        $conn->query("DELETE FROM reviews WHERE id = $reviewId");
    }
}

// -------------------- Fetch data for display --------------------
$packagesResult    = $conn->query("SELECT * FROM packages") or die($conn->error);
$booksResult       = $conn->query("SELECT * FROM book") or die($conn->error);
$reviewsResult     = $conn->query("SELECT * FROM reviews") or die($conn->error);
$contactInfoResult = $conn->query("SELECT * FROM contact") or die($conn->error);

$totalPackages = $conn->query("SELECT COUNT(*) AS total FROM packages")->fetch_assoc()['total'];
$totalBookings = $conn->query("SELECT COUNT(*) AS total FROM book")->fetch_assoc()['total'];
$totalReviews  = $conn->query("SELECT COUNT(*) AS total FROM reviews")->fetch_assoc()['total'];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TourX Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0; padding: 0;
    }
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #333;
      padding: 10px 20px;
      color: #fff;
    }
    .nav-links {
      display: flex;
      gap: 20px;
    }
    .nav-links a {
      color: #fff;
      text-decoration: none;
      padding: 8px 12px;
      border-radius: 4px;
    }
    .nav-links a:hover,
    .nav-links a.active {
      background: #575757;
    }
    .content {
      display: none;
      padding: 20px;
    }
    .content#home {
      display: block;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    table, th, td {
      border: 1px solid #ddd;
    }
    th, td {
      padding: 8px;
      text-align: left;
    }
    img {
      max-width: 100px;
      height: auto;
    }
    .form-container {
      margin: 15px 0;
      padding: 15px;
      border: 1px solid #ccc;
      background: #f9f9f9;
    }
    .btn {
      padding: 6px 12px;
      margin: 2px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .btn-primary {
      background-color: #007bff;
      color: white;
    }
    .btn-danger {
      background-color: #dc3545;
      color: white;
    }
  </style>
</head>
<body>

<div class="navbar">
  <h2>TourX Admin Dashboard</h2>
  <div class="nav-links">
    <a href="#home" class="active">Home</a>
    <a href="#packages">Packages</a>
    <a href="#booking">Booking</a>
    <a href="#reviews">Reviews</a>
    <a href="#usercomments">User Comments</a>
    <a href="admin_register.php">Register Admin</a>
    <a href="logout.php">Logout</a>
  </div>
</div>

<div id="home" class="content">
  <h2>Dashboard Overview</h2>
  <p>Total Packages: <strong><?= $totalPackages ?></strong></p>
  <p>Total Bookings: <strong><?= $totalBookings ?></strong></p>
  <p>Total Reviews: <strong><?= $totalReviews ?></strong></p>
</div>

<!-- Packages Section -->
<div id="packages" class="content">
  <h2>Manage Packages</h2>
  <button class="btn btn-primary" onclick="showForm()">Add New Package</button>

  <div id="packageForm" class="form-container" style="display:none;">
    <h3 id="formTitle">Add Package</h3>
    <form method="POST" enctype="multipart/form-data" id="packageFormElement">
      <input type="hidden" name="package_action" value="add" id="package_action">
      <input type="hidden" name="package_id" id="package_id" value="">
      <input type="hidden" name="existing_image" id="existing_image" value="">
      <label>Name:<br>
        <input type="text" name="package_name" id="package_name" required>
      </label><br><br>
      <label>Price:<br>
        <input type="number" step="0.01" name="package_price" id="package_price" required>
      </label><br><br>
      <label>Description:<br>
        <textarea name="package_description" id="package_description" required></textarea>
      </label><br><br>
      <label>Image:<br>
        <input type="file" name="package_image" id="package_image" onchange="previewImage(this)">
      </label><br>
      <img id="imagePreview" style="display:none;max-width:200px;" alt="Image Preview"><br>
      <button type="submit" class="btn btn-primary">Save</button>
      <button type="button" class="btn" onclick="hideForm()">Cancel</button>
    </form>
  </div>

  <table>
    <thead>
      <tr>
        <th>Name</th><th>Price</th><th>Description</th><th>Image</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $packagesResult->fetch_assoc()) : ?>
      <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['price']) ?></td>
        <td><?= htmlspecialchars($row['description']) ?></td>
        <td>
          <?php if ($row['image'] && file_exists('uploads/' . $row['image'])): ?>
            <img src="uploads/<?= htmlspecialchars($row['image']) ?>" alt="Package Image">
          <?php else: ?>
            No image
          <?php endif; ?>
        </td>
        <td>
          <button class="btn btn-primary" onclick="editPackage(
            <?= $row['id'] ?>,
            <?= json_encode($row['name']) ?>,
            <?= $row['price'] ?>,
            <?= json_encode($row['description']) ?>,
            <?= json_encode($row['image']) ?>
          )">Edit</button>
          <form method="POST" style="display:inline;" onsubmit="return confirm('Delete this package?')">
            <input type="hidden" name="package_action" value="delete">
            <input type="hidden" name="package_id" value="<?= $row['id'] ?>">
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Booking Section -->
<div id="booking" class="content">
  <h2>Bookings</h2>
  <table>
    <thead>
      <tr><th>Username</th><th>Where To</th><th>How Many</th><th>Arrival Date</th><th>Leaving Date</th></tr>
    </thead>
    <tbody>
      <?php while ($row = $booksResult->fetch_assoc()) : ?>
      <tr>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['where_to']) ?></td>
        <td><?= htmlspecialchars($row['how_many']) ?></td>
        <td><?= htmlspecialchars($row['arrivals_date']) ?></td>
        <td><?= htmlspecialchars($row['leaving_date']) ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Reviews Section -->
<div id="reviews" class="content">
  <h2>Admin Reviews</h2>
  <form method="POST" style="margin-bottom: 20px;">
    <input type="hidden" name="review_action" value="add">
    <label>Name: <input type="text" name="review_name" required></label>
    <label>Comment: <input type="text" name="review_comment" required></label>
    <button type="submit">Add Review</button>
  </form>
  <table>
    <thead>
      <tr><th>Name</th><th>Comment</th><th>Date</th><th>Action</th></tr>
    </thead>
    <tbody>
      <?php while ($row = $reviewsResult->fetch_assoc()) : ?>
      <tr>
        <td><?= htmlspecialchars($row['reviewName']) ?></td>
        <td><?= htmlspecialchars($row['comment']) ?></td>
        <td><?= htmlspecialchars($row['rdate']) ?></td>
        <td>
          <form method="POST" style="display:inline;" onsubmit="return confirm('Delete review?')">
            <input type="hidden" name="review_action" value="delete">
            <input type="hidden" name="review_id" value="<?= $row['id'] ?>">
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- User Comments Section -->
<div id="usercomments" class="content">
  <h2>User Comments</h2>
  <table>
    <thead><tr><th>Name</th><th>Comment</th><th>Date</th><th>Rating</th></tr></thead>
    <tbody>
      <?php while ($row = $contactInfoResult->fetch_assoc()) : ?>
      <tr>
        <td><?= htmlspecialchars($row['name']) ?></td>
        <td><?= htmlspecialchars($row['comment']) ?></td>
        <td><?= htmlspecialchars($row['comment_dtae']) ?></td>
        <td><?= htmlspecialchars($row['rating']) ?>/5</td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<script>
  function showSection(sectionId) {
    document.querySelectorAll('.content').forEach(el => el.style.display = 'none');
    document.getElementById(sectionId).style.display = 'block';
    document.querySelectorAll('.nav-links a').forEach(link => link.classList.remove('active'));
    const activeLink = document.querySelector(`.nav-links a[href="#${sectionId}"]`);
    if (activeLink) activeLink.classList.add('active');
  }

  function showForm() {
    document.getElementById('packageForm').style.display = 'block';
    document.getElementById('formTitle').textContent = 'Add Package';
    document.getElementById('package_action').value = 'add';
    document.getElementById('packageFormElement').reset();
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('existing_image').value = '';
    document.getElementById('package_id').value = '';
  }

  function hideForm() {
    document.getElementById('packageForm').style.display = 'none';
  }

  function editPackage(id, name, price, description, image) {
    document.getElementById('packageForm').style.display = 'block';
    document.getElementById('formTitle').textContent = 'Edit Package';
    document.getElementById('package_action').value = 'update';
    document.getElementById('package_id').value = id;
    document.getElementById('package_name').value = name;
    document.getElementById('package_price').value = price;
    document.getElementById('package_description').value = description;
    document.getElementById('existing_image').value = image;

    if(image) {
      document.getElementById('imagePreview').src = 'uploads/' + image;
      document.getElementById('imagePreview').style.display = 'block';
    } else {
      document.getElementById('imagePreview').style.display = 'none';
    }
  }

  function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    if(input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        preview.src = e.target.result;
        preview.style.display = 'block';
      }
      reader.readAsDataURL(input.files[0]);
    } else {
      preview.style.display = 'none';
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.nav-links a').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const id = this.getAttribute('href').substring(1);
        showSection(id);
      });
    });
    showSection('home');
  });
</script>
</body>
</html>
