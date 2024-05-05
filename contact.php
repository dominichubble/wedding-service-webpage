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
    <div class="contact-container">
        <h1>Contact Us</h1>
        <form id="contactForm">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <button type="submit">Send Message</button>
            <div id="formFeedback"></div>
        </form>
    </div>

    <script src="contact.js"></script> <!-- Link to your JavaScript file -->
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = strip_tags(trim($_POST["message"]));

    // Assume all data is valid and not empty
    // Here you can integrate an email sending function or database insertion
    //echo "Success";  // Respond back to the AJAX call
} else {
    // Not a POST request
    header('HTTP/1.1 400 Bad Request', true, 400);
    //echo "Invalid request";
}
?>