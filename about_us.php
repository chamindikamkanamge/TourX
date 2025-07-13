<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us | TourX</title>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .about-container {
            max-width: 1100px;
            margin: 60px auto;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .about-container h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .about-container img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
        }

        .about-text {
            margin-top: 30px;
            font-size: 17px;
            line-height: 1.8;
            color: #333333;
        }

        .highlight {
            color: #007bff;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .about-container {
                margin: 20px;
                padding: 20px;
            }

            .about-text {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<div class="about-container">
    <h1>About <span class="highlight">TourX</span></h1>
    <img src="uploads/banner-3.jpg" alt="Travel with TourX">
    <div class="about-text">
        <p><strong>TourX</strong> is your trusted partner in discovering the hidden gems of Sri Lanka. We specialize in offering customized travel packages to suit your interests, from pristine beaches and lush tea plantations to ancient ruins and vibrant cities.</p>

        <p>Founded with a passion for exploration and a commitment to quality, TourX makes traveling seamless, affordable, and unforgettable. Whether you're a solo traveler, a couple, or a family, we provide <span class="highlight">safe, reliable, and well-curated travel experiences</span>.</p>

        <p>Our team is dedicated to ensuring your journey is smooth and exciting — from the moment you book to the moment you return home. Let TourX be your gateway to the wonders of Sri Lanka!</p>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
