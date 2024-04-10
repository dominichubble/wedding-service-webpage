<?php
session_start(); // Start the session at the beginning of the script

if (isset($_POST['findVenues'])) {
    // Validate input
    $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
    $partySize = filter_input(INPUT_POST, 'partySize', FILTER_VALIDATE_INT);
    $cateringGrade = filter_input(INPUT_POST, 'cateringGrade', FILTER_VALIDATE_INT);

    if (!$date || !$partySize || !$cateringGrade || $partySize <= 0 || $cateringGrade < 1 || $cateringGrade > 5) {
        $_SESSION['results'] = "Invalid input provided. Please check your entries and try again.";
        header('Location: wedding.php');
        exit();
    }

    // Set up database connection
    $conn = new mysqli('sci-mysql', 'coa123wuser', 'grt64dkh!@2FD', 'coa123wdb');
    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error); // Log error to server's error log
        $_SESSION['results'] = "Failed to connect to the database. Please try again later.";
        header('Location: wedding.php');
        exit();
    }

    // SQL query setup
    $sql = "SELECT venue.name, venue.capacity, venue.weekend_price, venue.weekday_price, catering.cost, 
            COALESCE(AVG(venue_review_score.score)/2, 0) AS average_rating
            FROM venue
            JOIN catering ON venue.venue_id = catering.venue_id
            LEFT JOIN venue_booking ON venue.venue_id = venue_booking.venue_id AND venue_booking.booking_date = ?
            LEFT JOIN venue_review_score ON venue.venue_id = venue_review_score.venue_id
            WHERE venue.capacity >= ? AND catering.grade = ? AND venue_booking.venue_id IS NULL
            GROUP BY venue.name, venue.capacity, venue.weekend_price, venue.weekday_price, catering.cost
            ORDER BY venue.capacity ASC";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sii", $date, $partySize, $cateringGrade);
        $stmt->execute();
        $result = $stmt->get_result();

        $_SESSION['results'] = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $_SESSION['results'][] = $row;
            }
        } else {
            $_SESSION['results'] = "No venues found matching your criteria.";
        }
        $stmt->close();
    } else {
        $_SESSION['results'] = "Failed to prepare the database query. Please try again later.";
    }

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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Roboto', sans-serif; margin: 0; padding: 0; background: #eee; }
        header {
            background: url('wedding_banner.jpg') no-repeat center center/cover;
            height: 200px;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            text-shadow: 1px 1px 0 #000;
        }
        form {
            background: #fff;
            padding: 20px;
            margin: 20px auto;
            width: 90%;
            max-width: 500px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .venue {
            background: #fff;
            margin: 10px auto;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        label, input, select, button {
            display: block;
            width: 100%;
            margin-top: 10px;
        }
        button {
            color: #fff;
            background: #007BFF;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .error { color: red; }
    </style>
</head>
<body>
    <header>Wedding Venue Finder</header>
    <form method="post">
        <label for="date">Date:</label>
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
        
        <button type="submit" name="findVenues">Find Venues</button>
    </form>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const date = document.getElementById('date').value;
        const partySize = document.getElementById('partySize').value;
        const grade = document.getElementById('cateringGrade').value;
        
        if (!date || partySize <= 0 || grade < 1 || grade > 5) {
            e.preventDefault(); // Prevent form submission
            alert("Please check your inputs. Make sure dates are selected and values are within the allowed ranges.");
            return false;
        }
    });
});
</script>
<?php
if (isset($_SESSION['results'])) {
    if (is_array($_SESSION['results'])) {
        foreach ($_SESSION['results'] as $row) {
            // Replace spaces with underscores and convert the venue name to lowercase for the image name
            $imageName = strtolower(str_replace(" ", "_", $row["name"])) . ".jpg";
            $imagePath = $imageName; // Assuming the images are stored in a specific folder

            $rating = round($row["average_rating"], 1);
            $stars = str_repeat("★", floor($rating)) . (floor($rating) < $rating ? "½" : "");
            $emptyStars = str_repeat("☆", 5 - ceil($rating));
            
            echo "<div class='venue'><img src='" . htmlspecialchars($imagePath) . "' alt='Image of " . htmlspecialchars($row["name"]) . "' style='float: left; margin-right: 10px; width: 100px; height: 100px; object-fit: cover; border-radius: 5px;'>" .
                 "<strong>" . htmlspecialchars($row["name"]) . "</strong><br>" .
                 "Capacity: " . htmlspecialchars($row["capacity"]) . "<br>" .
                 "Price (Weekend): £" . htmlspecialchars($row["weekend_price"]) . "<br>" .
                 "Price (Weekday): £" . htmlspecialchars($row["weekday_price"]) . "<br>" .
                 "Catering Cost (Per Person): £" . htmlspecialchars($row["cost"]) . "<br>" .
                 "Rating: " . $stars . $emptyStars . " (" . $rating . "/5)</div>";
        }
    } else {
        echo "<p class='error'>" . $_SESSION['results'] . "</p>";
    }
    unset($_SESSION['results']); // Clear the results from session after displaying
}
?>

</body>
</html>
