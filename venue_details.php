<?php
require_once 'db_connection.php';

// Retrieve the venue ID from the URL query parameter
$venueId = isset($_GET['venue_id']) ? (int)$_GET['venue_id'] : 0;

// Query the database for the specific venue
$sql = "SELECT * FROM venue WHERE venue_id = ?";
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
    <!-- Your head content, like link to CSS file, title, etc. -->
</head>
<body>
    <header><!-- Your header content --></header>
    <main>
        <!-- Display the venue details -->
        <h1><?php echo htmlspecialchars($venueDetails['name']); ?></h1>
        <!-- Add more details you want to display, for example: -->
        <p>Capacity: <?php echo htmlspecialchars($venueDetails['capacity']); ?></p>
        <p>Weekend Price: £<?php echo htmlspecialchars($venueDetails['weekend_price']); ?></p>
        <!-- Add other elements as needed, such as a map, images, etc. -->
    </main>
</body>
</html>
