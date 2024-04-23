<?php
require_once 'db_connection.php'; // Include the database connection

session_start();

function getDayOfWeek($date) {
    $timestamp = strtotime($date);
    return date("w", $timestamp); // Returns day of the week (0 for Sunday, 6 for Saturday)
}

if (isset($_POST['findVenues'])) {
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
    $partySize = filter_input(INPUT_POST, 'partySize', FILTER_VALIDATE_INT);
    $cateringGrade = filter_input(INPUT_POST, 'cateringGrade', FILTER_VALIDATE_INT);

    if (!$date || !$partySize || !$cateringGrade || $partySize <= 0 || $cateringGrade < 1 || $cateringGrade > 5) {
        $_SESSION['results'] = "Invalid input provided. Please check your entries and try again.";
        header('Location: wedding.php');
        exit();
    }

    // Determine if it's a weekend
    $_SESSION['isWeekend'] = getDayOfWeek($date) == 0 || getDayOfWeek($date) == 6;

    // SQL query setup
    $sql = "SELECT venue.venue_id, venue.name, venue.capacity, venue.weekend_price, venue.weekday_price, catering.cost, 
    COALESCE(AVG(venue_review_score.score)/2, 0) AS average_rating
    FROM venue
    JOIN catering ON venue.venue_id = catering.venue_id
    LEFT JOIN venue_booking ON venue.venue_id = venue_booking.venue_id AND venue_booking.booking_date = ?
    LEFT JOIN venue_review_score ON venue.venue_id = venue_review_score.venue_id
    WHERE venue.capacity >= ? AND catering.grade = ? AND venue_booking.venue_id IS NULL
    GROUP BY venue.venue_id, venue.name, venue.capacity, venue.weekend_price, venue.weekday_price, catering.cost
    ORDER BY venue.capacity ASC";


    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("sii", $date, $partySize, $cateringGrade);
    $stmt->execute();
    $result = $stmt->get_result();

    // Process the results
    $_SESSION['results'] = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $totalPrice = ($_SESSION['isWeekend'] ? $row['weekend_price'] : $row['weekday_price']) + ($partySize * $row['cost']);
            $row['total_price'] = $totalPrice; // Add total price to the row array
            $_SESSION['results'][] = $row;
        }
    } else {
        $_SESSION['results'] = "No venues found matching your criteria.";
    }
    
    // Close statement and connection
    $stmt->close();
    
    header('Location: wedding.php');
    exit();
}

// Close the database connection
$conn->close();
?>
