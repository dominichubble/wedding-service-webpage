<?php
require 'db_connection.php';  // Ensure this file sets up a connection to your database

// SQL query that joins the venue, catering, and venue_review_score tables
$sql = "SELECT *
        FROM venue_booking";

$result = $conn->query($sql);

$venues = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $venues[] = $row;
    }
    // Encode the results into JSON
    $jsonBookingData = json_encode($venues, JSON_PRETTY_PRINT);
}

$conn->close();
