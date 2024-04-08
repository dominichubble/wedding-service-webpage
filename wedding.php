<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Venue Finder</title>
    <style>
        /* Inline CSS for demonstration purposes */
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
    $sql = "SELECT venue.name, venue.capacity, venue.weekend_price, venue.weekday_price, catering.cost
            FROM venue
            JOIN catering ON venue.venue_id = catering.venue_id
            LEFT JOIN venue_booking ON venue.venue_id = venue_booking.venue_id AND venue_booking.booking_date = ?
            WHERE venue.capacity >= ? AND catering.grade = ? AND venue_booking.venue_id IS NULL
            ORDER BY venue.capacity ASC";
    
    // Prepare statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $date, $partySize, $cateringGrade); // The first parameter is a string representing the date, followed by two integers
    
    // Execute query
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<div class='venue'><strong>" . htmlspecialchars($row["name"]) . "</strong><br>Capacity: " . htmlspecialchars($row["capacity"]) . "<br>Price (Weekend): £" . htmlspecialchars($row["weekend_price"]) . "<br>Price (Weekday): £" . htmlspecialchars($row["weekday_price"]) . "<br>Catering Cost (Per Person): £" . htmlspecialchars($row["cost"]) . "</div>";
        }
    } else {
        echo "<p>No venues found matching your criteria.</p>";
    }
    
    // Close connections
    $stmt->close();
    $conn->close();
}
?>
</body>
</html>
