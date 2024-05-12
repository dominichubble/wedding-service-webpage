<?php
include 'fetch_venue_data.php'; // This will include the PHP script logic
include 'fetch_venue_booking.php'; // This will include the PHP script logic
$venues = json_decode($jsonData, true);
$filtered_venues = null;
$bookings = json_decode($jsonBookingData, true);

$start = 0;
if ($start == 0) {
    $filtered_venues = $venues;
    $start = 1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filtered_venues = [];
    $date = $_POST['date'];
    $partySize = (int) $_POST['partySize'];
    $cateringGrade = (int) $_POST['cateringGrade'];

    foreach ($venues as $venue) {
        $isBooked = false;
        // Check bookings for each venue
        foreach ($bookings as $booking) {
            if ($booking['venue_id'] === $venue['venue_id'] && $booking['booking_date'] === $date) {
                $isBooked = true;
                break;  // No need to check further, venue is booked on this date
            }
        }
        // Check if the venue is not booked, has enough capacity, and matches the catering grade
        if ($isBooked == false && $venue['capacity'] >= $partySize && $venue['grade'] == $cateringGrade) {
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
    <h1>Available Venues</h1>
    <section>
        <div class="venue-filters">
            <form method="POST" action="find_a_venue.php">
                <label for="date">Wedding Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="partySize">Party Size: <span id="partySizeValue">200</span></label>
                <input type="range" id="partySize" name="partySize" min="50" max="1000" value="200"
                    oninput="updatePartySizeValue(this.value)" required>

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
        </div>
    </section>
    <section>
        <div id="venues-container">
            <?php
            $displayed_venues = []; // Array to keep track of displayed venues
            foreach ($filtered_venues as $venue):
                if (!in_array($venue['venue_id'], $displayed_venues)): // Check if the venue_id has already been displayed
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
                        <h2><?php echo htmlspecialchars($venue['name']); ?></h2>
                        <div class="venue-details">

                            <div class="venue-details-left">
                                <input type="hidden" id="lat-<?php echo $venue['venue_id']; ?>"
                                    value="<?php echo $venue['latitude']; ?>">
                                <input type="hidden" id="lng-<?php echo $venue['venue_id']; ?>"
                                    value="<?php echo $venue['longitude']; ?>">

                                <p>Capacity: <?php echo htmlspecialchars($venue['capacity']); ?></p>
                                <p>Weekend Price: £<?php echo htmlspecialchars($venue['weekend_price']); ?></p>
                                <p>Weekday Price: £<?php echo htmlspecialchars($venue['weekday_price']); ?></p>
                                <p>Cost Per Person: £<?php echo htmlspecialchars($venue['cost']); ?></p>
                                <p>Rating: <?php echo $stars . $emptyStars; ?> (<?php echo $rating; ?>/5)</p>
                            </div>
                            <div class="venue-details-right">
                                <p>Party Size: <?php echo htmlspecialchars($_POST['partySize']); ?></p>
                                <p>Wedding Date: <?php echo htmlspecialchars($_POST['date']); ?></p>


                                <p>Catering Grade: <?php echo htmlspecialchars($_POST['cateringGrade']); ?></p>

                                <?php
                                $isWeekend = false;
                                $date = $_POST['date'];
                                $dayOfWeek = date('N', strtotime($date));
                                if ($dayOfWeek >= 6) {  // 6 and 7 correspond to Saturday and Sunday
                                    $isWeekend = true;
                                } else {
                                    $isWeekend = false;
                                }
                                //echo "<script>console.log('"."is weekend: ".$isWeekend."');</script>";
                        
                                if ($isWeekend) {
                                    $totalCost = $venue['weekend_price'] + $venue['cost'] * $_POST['partySize'];
                                } else {
                                    $totalCost = $venue['weekday_price'] + $venue['cost'] * $_POST['partySize'];
                                }
                                ?>
                                <p>Catering Cost: £<?php echo htmlspecialchars($venue['cost'] * $_POST['partySize']); ?></p>
                                <p>Venue Cost: £<?php echo $isWeekend ? $venue['weekend_price'] : $venue['weekday_price']; ?>
                                </p>

                            </div>

                        </div>
                        <p><b>Total Cost: £<?php echo $totalCost ?></b></p>
                        <div class="venue-booking">
                            <button type="button" onclick="toggleModal(true, '<?php echo $venue['venue_id']; ?>')">Book
                                Venue</button>
                        </div>
                    </div>
                <?php endif;
            endforeach;
            ?>
        </div>
    </section>
    <div id="emailModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="toggleModal(false)">&times;</span>
            <h2>Confirm Your Booking</h2>
            <form id="emailForm">
                <input type="hidden" id="venueId" name="venueId">
                <label for="email">Enter your Email:</label>
                <input type="email" id="email" name="email" required>
                <button type="submit">Send Confirmation</button>
            </form>
            <div id="modalMessage"></div>
        </div>
    </div>
    
    <script src="script.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPg0GGMpyIU-6sU32eNEAWz1GqcrwVTW0&callback=initMap&v=weekly"></script>
    <footer>
        <p>Copyright © 2024 Vows & Venues. All rights reserved.</p>
    </footer>
</body>

</html>