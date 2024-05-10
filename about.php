<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Vows & Venues</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="logo.ico">
</head>

<body>
<header>
        <div class="nav_container">
            <nav class="nav_checkbox">
                <a href="wedding.php" class="logo"><h2>Vows & Venues</h2></a>
                <input type="checkbox" id="tab_nav" class="tab_nav">
                <label for="tab_nav" class="label">
                    <div class="burger"></div>
                    <div class="burger"></div>
                    <div class="burger"></div>
                </label>
                <ul class="content_nav">
                    <li><a href="wedding.php">Home</a></li>
                    <li><a href="find_a_venue.php">Find a Venue</a></li>
                    <li><a href="compare.php">Compare Venues</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>
        
    </header>
    <h1>About Vows & Venues</h1>
    <main>
        <div class="about-section">
            <h2>Our Mission</h2>
            <p>At Vows & Venues, our mission is to simplify the journey of booking your dream wedding venue. We believe that every couple deserves a magical and stress-free wedding experience, and our goal is to make that possible through a seamless, transparent, and user-friendly online platform.</p>
        </div>
        <div class="about-section">
            <h2>What We Do</h2>
            <p>At Vows & Venues, we streamline the search for your perfect wedding venue by offering a curated selection of high-quality options tailored to meet diverse tastes and budgets. Our platform features advanced search tools, detailed venue information, virtual tours, and personalized recommendations, ensuring a seamless and stress-free experience. From the initial search to the final booking, we provide all the resources you need to find and secure a venue that perfectly matches your vision and preferences, making your special day unforgettable.</p>
        </div>
        <div class="about-section">
            <h2>Meet Our Team</h2>
            <div class="team-members">
                <div class="team-member">
                    <img src="frontend_dev.JPG" alt="Team Member 1">
                    <p>Name: Dominic Hubble</p>
                    <p>Role: Front-End Developer</p>
                </div>
                <div class="team-member">
                    <img src="wedding_planner.jpg" alt="Team Member 2">
                    <p>Name: Dominic Hubble</p>
                    <p>Role: Wedding Planner</p>
                </div>
                <div class="team-member">
                    <img src="backend_dev.JPG" alt="Team Member 2">
                    <p>Name: Dominic Hubble</p>
                    <p>Role: Back-End Developer</p>
                </div>
            </div>
        </div>
    </main>
    <section id="booking-graph">
        <h2>Venue Booking Trends</h2>
        <canvas id="bookingChart"></canvas>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="about.js"></script>

    <footer>
        <p>Copyright © 2024 Vows & Venues. All rights reserved.</p>
    </footer>
</body>

</html>