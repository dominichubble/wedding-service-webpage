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
    <h1>About Us</h1>
    <section>
        <p>Welcome to Vows & Venues, your ultimate destination for booking the perfect venue for your wedding day.
            Founded in 2024, we specialize in helping couples find and book venues that match their vision, budget, and
            requirements, ensuring a seamless and memorable experience.</p>
        <p>Our service offers personalized consultations, a wide range of venue options, and exclusive deals that make
            your special day as enchanting as possible.</p>
    </section>
    <section id="booking-graph">
        <h2>Venue Booking Trends</h2>
        <canvas id="bookingChart"></canvas>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="about.js"></script>


</body>

</html>