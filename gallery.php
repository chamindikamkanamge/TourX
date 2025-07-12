<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Image Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Navbar Styles */
        .navbar {
            background-color: #333;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #fff;
        }
        .navbar h2 {
            margin: 0;
            font-size: 22px;
        }
        .navbar a {
            text-decoration: none;
            color: #fff;
            background-color: #007BFF;
            padding: 8px 16px;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .navbar a:hover {
            background-color: #0056b3;
        }

        /* Gallery Styles */
        h1 {
            text-align: center;
            margin: 30px 0 20px;
        }
        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: auto;
            padding: 0 30px 40px;
        }
        .frame {
            background-color: white;
            border: 5px solid #ccc;
            padding: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            border-radius: 8px;
            transition: 0.3s;
        }
        .frame:hover {
            transform: scale(1.03);
            border-color: #555;
        }
        .frame img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
        }
        .caption {
            text-align: center;
            margin-top: 8px;
            font-size: 14px;
            color: #444;
        }
    </style>
</head>
<body>

<!-- ✅ Top Menubar -->

    <h2>TourX Gallery</h2>
    <div class="bg-img" style="background-image: url('img/2.png');">
        
             <div class="navbar">
            <p> <a href="home.php">Home</a> / Gallery </p>
        </div>


<h1>Image Gallery</h1>

<div class="gallery">
    <?php
    $basePath = "uploads/";
    
    $imageNames = [
        "1.png", "2.png", "3.png", "4.png", "5.png",
        "6.png", "7.png", "8.png", "9.png", "10.png",
        "11.png", "12.png", "13.png", "14.png", "15.png",
        "16.png", "17.png", "18.png", "19.png", "55.jpg"
        
    ];

    foreach ($imageNames as $img) {
        $url = $basePath . $img;
        echo "
        <div class='frame'>
            <img src='$url' alt='Image'>
            <div class='caption'>$img</div>
        </div>";
    }
    ?>
</div>

</body>
</html>
