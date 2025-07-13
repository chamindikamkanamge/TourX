<?php
// Start session if not already running (needed for Admin link / logout etc.)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- NAVBAR -->
<header>
    <style>
        /* ――― simple responsive navbar ――― */
       .navbar {
    max-width: 1100px;
    margin: 0 auto;
    padding: 4px 10px;          /* reduced padding */
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 14px;            /* smaller font base */
}

.logo a {
    font-size: 1.1rem;          /* slightly smaller logo text */
    font-weight: 700;
    text-decoration: none;
    color: #007bff;
}

.nav-menu {
    list-style: none;
    display: flex;
    gap: 15px;                  /* reduced gap */
    margin: 0;
    padding: 0;
}

.nav-menu a {
    color: #2c3e50;
    text-decoration: none;
    font-weight: 500;
    transition: .2s;
    padding: 2px 4px;           /* reduced padding for click area */
    font-size: 13px;            /* slightly smaller font */
}

.nav-menu a:hover {
    color: #007bff;
}

/* Mobile adjustments */
@media (max-width: 768px) {
    .hamburger {
        display: block;
        font-size: 20px;        /* smaller hamburger */
        cursor: pointer;
        color: #2c3e50;
    }
    .nav-menu {
        position: absolute;
        top: 40px;              /* reduced from 50px */
        left: 0;
        right: 0;
        background: #fff;
        flex-direction: column;
        align-items: center;
        max-height: 0;
        overflow: hidden;
        transition: max-height .3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,.1);
    }
    #nav-toggle:checked + .hamburger + .nav-menu {
        max-height: 250px;      /* reduced from 300px */
    }
}
    </style>

    <nav class="navbar">
        <div class="logo"><a href="home.php">TourX</a></div>
 
        

        <nav class="navbar">
    <a href="home.php">home</a>
    <a href="packages.php">packages</a>
    <a href="about_us.php">about</a>
    <a href="images.php">gallery</a> <!-- ✅ Fixed -->
    <a href="reviews.php">review</a>
    <a href="contact.php">contact</a>
 

        <div class="icons">
            <a href="search.php"><i class="fas fa-search" id="search-icon"></i></a>
            <a href="login_user.php"><i class="fas fa-user" id="login-icon"></i></a>
        </div>

        <form action="" class="search-bar-container">
            <input type="search" id="search-bar" placeholder="search here...">
            <label for="search-bar" class="fas fa-search"></label>
        </form>

            
</header>