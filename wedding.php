<?php
include 'venue_finder.php'; // This will include the PHP script logic
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vows & Venues - Find Your Perfect Wedding Venue</title>
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>

<body>
    <header>
        <img src="Vows_&_Venues_logo.png" alt="Vows & Venues Logo" id="logo"> <!-- Make sure the src matches the location of your logo file -->
        <h1>Welcome to Vows & Venues</h1>
    </header>
    <form method="post">
        <label for="date">Wedding Date:</label>
        <input type="date" id="date" name="date" required>
        
        <label for="partySize">Party Size:</label>
        <input type="number" id="partySize" name="partySize" required min="1">
        
        <label for="cateringGrade">Catering Grade:</label>
        <select id="cateringGrade" name="cateringGrade">
            <option value="1">Basic</option>
            <option value="2">Standard</option>
            <option value="3">Good</option>
            <option value="4">Superior</option>
            <option value="5">Luxury</option>
        </select>
        
        <button type="submit" name="findVenues">Search Venues</button>
    </form>
    <?php
    if (isset($_SESSION['results'])) {
        if (is_array($_SESSION['results'])) {
            echo "<div class='results-container'>";
            foreach ($_SESSION['results'] as $row) {
                $imageName = strtolower(str_replace(" ", "_", $row["name"])) . ".jpg";
                $imagePath = $imageName;  // Assuming images are in the same folder as the PHP file

                $rating = round($row["average_rating"], 1);
                $stars = str_repeat("★", floor($rating)) . (floor($rating) < $rating ? "½" : "");
                $emptyStars = str_repeat("☆", 5 - ceil($rating));
                $totalPrice = $row['total_price'];

                echo "<div class='venue clearfix'>";
echo "<a href='venue_details.php?venue_id=" . $row['venue_id'] . "'>";
echo "<img src='" . htmlspecialchars($imagePath) . "' alt='Image of " . htmlspecialchars($row["name"]) . "'>";

echo "<div>";
echo "<strong>" . htmlspecialchars($row["name"]) . "</strong><br>";
echo "Capacity: " . htmlspecialchars($row["capacity"]) . "<br>";
echo "Price: £" . htmlspecialchars($_SESSION['isWeekend'] ? $row['weekend_price'] : $row['weekday_price']) . "<br>";
echo "Catering Cost: £" . htmlspecialchars($row["cost"]) . " per person<br>";
echo "Total Price: £" . htmlspecialchars($totalPrice) . "<br>";
echo "Rating: " . $stars . $emptyStars . " (" . $rating . "/5)";

echo "</div></div></a>";

            }
            echo "</div>";
        } else {
            echo "<p class='error'>" . $_SESSION['results'] . "</p>";
        }
        unset($_SESSION['results']);
    }
    ?>
</body>
</html>