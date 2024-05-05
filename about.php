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
        <img src="logo.png" alt="Vows & Venues Logo" class="logo">
        <nav>
            <div class="nav_links">
                <ul>
                    <li><a href="wedding.php">Home</a></li>
                    <li><a href="find_a_venue.php">Find a Venue</a></li>
                    <li><a href="about.php">About Us</a></li>
                </ul>
            </div>
        </nav>
        <a class="cta" href="contact.php"><button>Contact</button></a>
    </header>
    <h1>About Vows & Venues</h1>
    <main>
        <div class="about-section">
            <h2>Our Mission</h2>
            <p>We strive to provide the best wedding venue options...</p>
        </div>
        <div class="about-section">
            <h2>What We Do</h2>
            <p>Explore our curated lists of venues...</p>
        </div>
        <div class="about-section">
            <h2>Meet Our Team</h2>
            <div class="team-members">
                <div class="team-member">
                    <img src="-ashby_castle.jpg" alt="Team Member 1">
                    <p>Name: Dominic Hubble</p>
                    <p>Role: Front-End Developer</p>
                </div>
                <div class="team-member">
                    <img src="-ashby_castle.jpg" alt="Team Member 2">
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