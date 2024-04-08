<?php
session_start(); // Start the session at the beginning of the script

if (isset($_POST['findVenues'])) {
    // Connect to the database
    $conn = new mysqli('sci-mysql', 'coa123wuser', 'grt64dkh!@2FD', 'coa123wdb');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $date = $_POST['date'];
    $partySize = $_POST['partySize'];
    $cateringGrade = $_POST['cateringGrade'];
    
    // Adjusted SQL query to match the catering grade exactly
    $sql = "SELECT venue.name, venue.capacity, venue.weekend_price, venue.weekday_price, catering.cost, 
    COALESCE(AVG(venue_review_score.score)/2, 0) AS average_rating
    FROM venue
    JOIN catering ON venue.venue_id = catering.venue_id
    LEFT JOIN venue_booking ON venue.venue_id = venue_booking.venue_id AND venue_booking.booking_date = ?
    LEFT JOIN venue_review_score ON venue.venue_id = venue_review_score.venue_id
    WHERE venue.capacity >= ? AND catering.grade = ? AND venue_booking.venue_id IS NULL
    GROUP BY venue.name, venue.capacity, venue.weekend_price, venue.weekday_price, catering.cost
    ORDER BY venue.capacity ASC";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $date, $partySize, $cateringGrade);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $_SESSION['results'] = []; // Initialize session variable to store results
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $_SESSION['results'][] = $row;
        }
    } else {
        $_SESSION['results'] = "No venues found matching your criteria.";
    }
    
    $stmt->close();
    $conn->close();
    
    header('Location: wedding.php'); // Redirect to clear POST data
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Venue Finder</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        label, select, input[type="date"], input[type="number"], button { margin-top: 10px; }
        .venue { margin-top: 20px; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>Find Your Perfect Wedding Venue</h1>
    <form method="post">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        
        <label for="partySize">Party Size:</label>
        <input type="number" id="partySize" name="partySize" required>
        
        <label for="cateringGrade">Catering Grade:</label>
        <select id="cateringGrade" name="cateringGrade">
            <option value="1">Basic</option>
            <option value="2">Standard</option>
            <option value="3">Good</option>
            <option value="4">Superior</option>
            <option value="5">Luxury</option>
        </select>
        
        <button type="submit" name="findVenues">Find Venues</button>
    </form>

<?php
if (isset($_SESSION['results'])) {
    if (is_array($_SESSION['results'])) {
        foreach ($_SESSION['results'] as $row) {
            $rating = round($row["average_rating"], 1); // Round to 1 decimal place
            $stars = str_repeat("★", floor($rating)) . (floor($rating) < $rating ? "½" : ""); // Full and half stars
            $emptyStars = str_repeat("☆", 5 - ceil($rating)); // Empty stars to fill up to 5
            
            echo "<div class='venue'><strong>" . htmlspecialchars($row["name"]) . "</strong><br>" .
                 "Capacity: " . htmlspecialchars($row["capacity"]) . "<br>" .
                 "Price (Weekend): £" . htmlspecialchars($row["weekend_price"]) . "<br>" .
                 "Price (Weekday): £" . htmlspecialchars($row["weekday_price"]) . "<br>" .
                 "Catering Cost (Per Person): £" . htmlspecialchars($row["cost"]) . "<br>" .
                 "Rating: " . $stars . $emptyStars . " (" . $rating . "/5)" . "</div>";
        }
    } else {
        // Display message if no venues were found
        echo "<p>{$_SESSION['results']}</p>";
    }
    unset($_SESSION['results']); // Clear the results from session
}
?>
</body>
</html>
