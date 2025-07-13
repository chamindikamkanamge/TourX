<?php
session_start();
include 'config.php';

// Error reporting configuration (turn off in production)
error_reporting(E_ALL);
ini_set('display_errors', 0); // Set to 1 for development, 0 for production

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
    $image = '';

    // Handle image upload if provided
    if (!empty($_FILES['review_image']['name'])) {
        $uploadDir = 'users/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $image = basename($_FILES['review_image']['name']);
        $target = $uploadDir . $image;
        move_uploaded_file($_FILES['review_image']['tmp_name'], $target);
    }

    if ($_POST['review_action'] === 'add') {
        $stmt = $conn->prepare("INSERT INTO reviews (reviewName, comment, rdate, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $name, $comment, $current_date, $image);
        $stmt->execute();
        $stmt->close();
    } elseif ($_POST['review_action'] === 'delete') {
        $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->bind_param('i', $reviewId);
        $stmt->execute();
        $stmt->close();
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
      margin: 0;
      padding: 0;
      background: url('/uploads/banner-3.jpg') center/cover no-repeat fixed;
      position: relative;
    }

    body::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5); /* Semi-transparent overlay */
      z-index: -1;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #333;
      padding: 10px 20px;
      color: #fff;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
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
      background: rgba(255, 255, 255, 0.9); /* Semi-transparent white background for content */
      border-radius: 5px;
      margin-top: 60px; /* Offset for fixed navbar */
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

    th {
      background-color: #f2f2f2;
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
      border-radius: 5px;
    }

    .btn {
      padding: 6px 12px;
      margin: 2px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 14px;
    }

    .btn-primary {
      background-color: #007bff;
      color: white;
    }

    .btn-danger {
      background-color: #dc3545;
      color: white;
    }

    textarea {
      width: 100%;
      min-height: 100px;
      padding: 8px;
      box-sizing: border-box;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"] {
      padding: 8px;
      width: 100%;
      box-sizing: border-box;
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
    <a href="admin_register.php" target="_self">Register Admin</a>
    <a href="logout.php" target="_self">Logout</a>
  </div>
</div>

<div id="home" class="content">
  <h2>Dashboard Overview</h2>
  <p>Total Packages: <strong><?= htmlspecialchars($totalPackages) ?></strong></p>
  <p>Total Bookings: <strong><?= htmlspecialchars($totalBookings) ?></strong></p>
  <p>Total Reviews: <strong><?= htmlspecialchars($totalReviews) ?></strong></p>
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
      <label>Name:
        <input type="text" name="package_name" id="package_name" required>
      </label>
      <label>Price:
        <input type="number" step="0.01" name="package_price" id="package_price" required>
      </label>
      <label>Description:
        <textarea name="package_description" id="package_description" required></textarea>
      </label>
      <label>Image:
        <input type="file" name="package_image" id="package_image" onchange="previewImage(this)">
      </label>
      <img id="imagePreview" style="display:none;max-width:200px;margin-top:10px;" alt="Image Preview">
      <div style="margin-top:15px;">
        <button type="submit" class="btn btn-primary">Save</button>
        <button type="button" class="btn" onclick="hideForm()">Cancel</button>
      </div>
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
        <td>$<?= number_format(htmlspecialchars($row['price']), 2) ?></td>
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
  <?php if ($booksResult->num_rows > 0): ?>
  <table>
    <thead>
      <tr><th>Username</th><th>Where To</th><th>How Many</th><th>Arrival Date</th><th>Leaving Date</th></tr>
    </thead>
    <tbody>
      <?php while ($row = $booksResult->fetch_assoc()) : ?>
      <tr>
        <td><?= htmlspecialchars($row['username'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['where_to'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['how_many'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['arrivals_date'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['leaving_date'] ?? '') ?></td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php else: ?>
  <p>No bookings found.</p>
  <?php endif; ?>
</div>

<!-- Reviews Section -->
<div id="reviews" class="content">
  <h2>Admin Reviews</h2>
  <div class="form-container">
    <form method="POST" enctype="multipart/form-data"> <!-- Added enctype for file upload -->
      <input type="hidden" name="review_action" value="add">
      <label>Name: <input type="text" name="review_name" required></label>
      <label style="margin-top:10px;">Comment: <textarea name="review_comment" required></textarea></label>
      <label style="margin-top:10px;">Image: <input type="file" name="review_image" accept="image/*"></label> <!-- Added image upload -->
      <div style="margin-top:15px;">
        <button type="submit" class="btn btn-primary">Add Review</button>
      </div>
    </form>
  </div>
  
  <?php if ($reviewsResult->num_rows > 0): ?>
  <table>
    <thead>
      <tr><th>Name</th><th>Comment</th><th>Date</th><th>Image</th><th>Action</th></tr>
    </thead>
    <tbody>
      <?php while ($row = $reviewsResult->fetch_assoc()) : ?>
      <tr>
        <td><?= htmlspecialchars($row['reviewName'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['comment'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['rdate'] ?? '') ?></td>
        <td>
          <?php if ($row['image'] && file_exists('users/' . $row['image'])): ?>
            <img src="users/<?= htmlspecialchars($row['image']) ?>" alt="Review Image" style="max-width: 100px; height: auto;">
          <?php else: ?>
            No image
          <?php endif; ?>
        </td>
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
  <?php else: ?>
  <p>No reviews found.</p>
  <?php endif; ?>
</div>

<!-- User Comments Section -->
<div id="usercomments" class="content">
  <h2>User Comments</h2>
  <?php if ($contactInfoResult->num_rows > 0): ?>
  <table>
    <thead><tr><th>Name</th><th>Subject</th><th>Message</th><th>Rating</th></tr></thead>
    <tbody>
      <?php while ($row = $contactInfoResult->fetch_assoc()) : ?>
      <tr>
        <td><?= htmlspecialchars($row['name'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['subject'] ?? '') ?></td>
        <td><?= htmlspecialchars($row['message'] ?? 'No message') ?></td>
        <td><?= htmlspecialchars($row['rating'] ?? '0') ?>/5</td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  <?php else: ?>
  <p>No user comments found.</p>
  <?php endif; ?>
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
        const href = this.getAttribute('href');
        // Check if the link is an external URL (not starting with #)
        if (!href.startsWith('#')) {
          // Allow navigation for external links
          return; // Let the browser handle the navigation
        }
        e.preventDefault();
        const id = href.substring(1);
        showSection(id);
      });
    });
    showSection('home');
  });
</script>
</body>
</html>