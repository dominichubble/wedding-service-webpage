<?php
require_once 'db_connection.php';

$venueId = isset($_GET['venue_id']) ? (int)$_GET['venue_id'] : 0;
if (!$venueId) {
    exit('Invalid Venue!');
}

$sql = "SELECT venue.*, venue_review_score.score AS average_score FROM venue 
        LEFT JOIN venue_review_score ON venue.venue_id = venue_review_score.venue_id 
        WHERE venue.venue_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $venueId);
$stmt->execute();
$venue = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();

if (!$venue) {
    exit('Venue not found.'); // Handle this case appropriately
}

// Replace spaces with underscores and add the .jpg extension for the image filename
$imageFilename = strtolower(str_replace(" ", "_", $venue['name'])) . '.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($venue['name']); ?> - Venue Details</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBPg0GGMpyIU-6sU32eNEAWz1GqcrwVTW0&callback=initMap&v=weekly" async defer></script>
    <script>
        function initMap() {
            var venue = {lat: <?php echo $venue['latitude']; ?>, lng: <?php echo $venue['longitude']; ?>};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: venue
            });
            var marker = new google.maps.Marker({position: venue, map: map});
        }
    </script>
</head>
<body>
    <header class="site-header">
        <h1><?php echo htmlspecialchars($venue['name']); ?></h1>
    </header>
    <section class="venue-images">
        <img src="<?php echo $imageFilename; ?>" alt="Main image of <?php echo htmlspecialchars($venue['name']); ?>" class="main-image">
    </section>
    <section class="venue-details">
        <h2>Details</h2>
        <p><strong>Capacity:</strong> <?php echo htmlspecialchars($venue['capacity']); ?> guests</p>
        <p><strong>Weekend Price:</strong> £<?php echo htmlspecialchars($venue['weekend_price']); ?></p>
        <p><strong>Weekday Price:</strong> £<?php echo htmlspecialchars($venue['weekday_price']); ?></p>
        <p><strong>Average Rating:</strong> <?php echo htmlspecialchars($venue['average_score']); ?> / 10</p>
        <div id="map" style="width: 100%; height: 400px;"></div>
    </section>
</body>
</html>
