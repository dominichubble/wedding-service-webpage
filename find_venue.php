<?php
include 'fetch_venue_data.php'; // This will include the PHP script logic
include 'bookings.php'; // This will include the PHP script logic
$venues = json_decode($jsonData, true);
echo "<script>console.log($jsonData);</script>";
$filtered_venues = null;
$bookings = json_decode($jsonBookingData, true);
echo "<script>console.log($jsonBookingData);</script>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $partySize = (int)$_POST['partySize'];
    $cateringGrade = (int)$_POST['cateringGrade'];

    foreach ($venues as $venue) {
        $isBooked = false;

        // Check bookings for each venue
        foreach ($venue['bookings'] as $booking) {
            if ($booking['booking_date'] === $date) {
                $isBooked = true;
                break;  // No need to check further, venue is booked on this date
            }
        }

        // Check if the venue is not booked, has enough capacity, and matches the catering grade
        if (!$isBooked && $venue['capacity'] >= $partySize && $venue['grade'] == $cateringGrade) {
            $filtered_venues[] = $venue;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find a Venue | Vows & Venues</title>
    <link rel="stylesheet" href="style.css">
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPg0GGMpyIU-6sU32eNEAWz1GqcrwVTW0&callback=initMap&v=weekly"></script>
</head>

<body>
    <nav class="navbar">
        <div class="navbar-content">
            <span class="site-name">Vows & Venues</span>
            <ul>
                <li><a href="wedding.php">Home</a></li>
                <li><a href="find_venue.php">Find a Venue</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
        </div>
    </nav>


    <form method="POST" action="find_venue.php">
        <label for="date">Wedding Date:</label>
        <input type="date" id="date" name="date" required>

        <label for="partySize">Party Size: <span id="partySizeValue">50</span></label>
        <input type="range" id="partySize" name="partySize" min="10" max="300" value="50" oninput="updatePartySizeValue(this.value)" required>

        <label for="cateringGrade">Catering Grade:</label>
        <select id="cateringGrade" name="cateringGrade">
            <option value="1">Basic</option>
            <option value="2">Standard</option>
            <option value="3">Good</option>
            <option value="4">Superior</option>
            <option value="5">Luxury</option>
        </select>

        <button type="submit" name="submit">Search Venues</button>
    </form>

    <h1>Available Venues</h1>
    <div id="venues-container">
        <?php
        $displayed_venues = []; // Array to keep track of displayed venues
        foreach ($filtered_venues as $venue) :
            if (!in_array($venue['venue_id'], $displayed_venues)) : // Check if the venue_id has already been displayed
                $displayed_venues[] = $venue['venue_id']; // Mark this venue_id as displayed
                $imageName = strtolower(str_replace(" ", "_", $venue["name"])) . ".jpg";
                $rating = round($venue["average_score"], 0);
                $stars = str_repeat("★", floor($rating));
                $emptyStars = str_repeat("☆", 5 - ceil($rating));
        ?>
                <div class="venue">
                <div class="venue-media">
                    <img src="<?php echo $imageName; ?>" alt="<?php echo htmlspecialchars($venue['name']); ?>">
                    <div id="map-<?php echo $venue['venue_id']; ?>" class="map"></div>
                </div>
                    <input type="hidden" id="lat-<?php echo $venue['venue_id']; ?>" value="<?php echo $venue['latitude']; ?>">
                    <input type="hidden" id="lng-<?php echo $venue['venue_id']; ?>" value="<?php echo $venue['longitude']; ?>">
                    <h2><?php echo htmlspecialchars($venue['name']); ?></h2>
                    <p>Capacity: <?php echo htmlspecialchars($venue['capacity']); ?></p>
                    <p>Weekend Price: £<?php echo htmlspecialchars($venue['weekend_price']); ?></p>
                    <p>Weekday Price: £<?php echo htmlspecialchars($venue['weekday_price']); ?></p>
                    <p>Rating: <?php echo $stars . $emptyStars; ?> (<?php echo $rating; ?>/5)</p>
                    <p>Latitude: <?php echo htmlspecialchars($venue['latitude']); ?></p>
                    <p>Longitude: <?php echo htmlspecialchars($venue['longitude']); ?></p>
                    

                </div>
        <?php endif;
        endforeach;
        ?>
    </div>





    <script src="script.js"></script>





</body>

</html>