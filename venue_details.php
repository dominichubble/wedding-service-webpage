<?php
require_once 'db_connection.php';

// Retrieve the venue ID from the URL query parameter
$venueId = isset($_GET['venue_id']) ? (int)$_GET['venue_id'] : 0;

// Query the database for the specific venue
$sql = "SELECT venue.*, venue_review_score.score AS average_score FROM venue 
        LEFT JOIN venue_review_score ON venue.venue_id = venue_review_score.venue_id 
        WHERE venue.venue_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $venueId);
$stmt->execute();
$result = $stmt->get_result();

$venueDetails = $result->fetch_assoc();

// Always check if the venue details are actually retrieved
if (!$venueDetails) {
    exit('Venue not found.'); // Handle this case appropriately
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($venueDetails['name']); ?> - Venue Details</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDYPHexyn65GlSNAZuxxYL71NO7dyF9CB0&callback=initMap&libraries=&v=weekly" defer></script>
    <script>
    function initMap() {
        // The location of the venue
        var venue = {lat: <?php echo $venueDetails['latitude']; ?>, lng: <?php echo $venueDetails['longitude']; ?>};
        // The map, centered at the venue
        var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 15, center: venue});
        // The marker, positioned at the venue
        var marker = new google.maps.Marker({position: venue, map: map});
    }
    </script>
</head>
<body>
    <header><!-- Your header content --></header>
    <main>
        <h1><?php echo htmlspecialchars($venueDetails['name']); ?></h1>
        <p>Capacity: <?php echo htmlspecialchars($venueDetails['capacity']); ?></p>
        <p>Weekend Price: £<?php echo htmlspecialchars($venueDetails['weekend_price']); ?></p>
        <p>Weekday Price: £<?php echo htmlspecialchars($venueDetails['weekday_price']); ?></p>
        <p>Average Score: <?php echo htmlspecialchars($venueDetails['average_score']); ?>/10</p>
        <div id="map" style="height: 400px; width: 100%;"></div>
    </main>
</body>
</html>
