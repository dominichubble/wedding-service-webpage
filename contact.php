<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact | Vows & Venues</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="logo.ico">
</head>

<body>
    <header>
        <div class="nav_container">
            <nav class="nav_checkbox">
                <a href="wedding.php" class="logo">
                    <h2>Vows & Venues</h2>
                </a>
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
    <h1>Contact Us</h1>
        <div class="about-section">
            <h2>Get in Touch</h2>
            <p>Have a question or feedback? Fill out the form below and we'll get back to you as soon as possible.</p>
        </div>
    <section>
        <div class="contact-form">
            <form id="contactForm" method="post">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <button type="submit">Send Message</button>
            </form>
            <div id="formFeedback"></div>
        </div>
    </section>

    <footer>
        <p>Copyright © 2024 Vows & Venues. All rights reserved.</p>
    </footer>
</body>
<script src="contact.js"></script>

</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"]));
}
?>