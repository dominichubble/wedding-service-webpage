<?php
require 'database_connection.php';  // Ensure this file sets up a connection to your database

// SQL query that joins the venue, catering, and venue_review_score tables
$sql = "SELECT v.venue_id, v.name, v.capacity, v.weekend_price, v.weekday_price, v.latitude, v.longitude, v.licensed,
               c.grade, c.cost,
               AVG(vrs.score)/2 AS average_score
        FROM venue v
        LEFT JOIN catering c ON v.venue_id = c.venue_id
        LEFT JOIN venue_review_score vrs ON v.venue_id = vrs.venue_id
        GROUP BY v.venue_id, v.name, v.capacity, v.weekend_price, v.weekday_price, v.latitude, v.longitude, c.grade, c.cost";

$result = $conn->query($sql);

$venues = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $venues[] = $row;
    }
    // Encode the results into JSON
    $jsonData = json_encode($venues, JSON_PRETTY_PRINT);
}

$conn->close();
