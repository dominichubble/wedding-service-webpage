<?php
require 'database_connection.php';  // Ensure this file sets up a connection to your database

// SQL query that joins the venue, catering, and venue_review_score tables
$sql = "SELECT *
        FROM venue_booking";

$result = $conn->query($sql);

$bookings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
    // Encode the results into JSON
    $jsonBookingData = json_encode($bookings, JSON_PRETTY_PRINT);
}

$conn->close();
