<?php
include 'fetch_venue_data.php'; // This will include the PHP script logic

$venues = json_decode($jsonData, true);

// Extract venue names into a separate array
$venueNames = array_map(function ($venue) {
    return $venue['name'];
}, $venues);

// Remove duplicates
$uniqueVenueNames = array_unique($venueNames);

$venue1Data = null;
$venue2Data = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $venue1Name = $_POST['venue1'];
    $venue2Name = $_POST['venue2'];

    // Find the data for the selected venues
    foreach ($venues as $venue) {
        if ($venue['name'] === $venue1Name) {
            $venue1Data = $venue;
        }

        if ($venue['name'] === $venue2Name) {
            $venue2Data = $venue;
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Vows & Venues</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="logo.ico">
</head>

<body>
    <header>
        <div class="nav_container">
            <nav class="nav_checkbox">
                <a href="wedding.php" class="logo">
                    <h2>Vows & Venues</h2>
                </a>
                <input type="checkbox" id="tab_nav" class="tab_nav">
                <label for="tab_nav" class="label">
                    <div class="burger"></div>
                    <div class="burger"></div>
                    <div class="burger"></div>
                </label>
                <ul class="content_nav">
                    <li><a href="wedding.php">Home</a></li>
                    <li><a href="find_a_venue.php">Find a Venue</a></li>
                    <li><a href="compare.php">Compare Venues</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </nav>
        </div>

    </header>
    <h1>Compare Venues</h1>

    <form method="POST" action="compare.php" class="compare-form">
        <label for="venue1">Venue 1:</label>
        <select id="venue1" name="venue1">
            <?php foreach ($uniqueVenueNames as $name): ?>
                <option value="<?= $name ?>" <?= $name == $venue1Name ? 'selected' : '' ?>><?= $name ?></option>
            <?php endforeach; ?>
        </select>
        <label for="venue2">Venue 2:</label>
        <select id="venue2" name="venue2">
            <?php foreach ($uniqueVenueNames as $name): ?>
                <option value="<?= $name ?>" <?= $name == $venue2Name ? 'selected' : '' ?>><?= $name ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" name="submit">Compare Venues</button>

        <?php if ($venue1Data && $venue2Data): ?>
            <div class="container">
                <h2>Comparison</h2>

                <table class="compare-table">
                    <thead>
                        <tr>
                            <th>Attribute</th>
                            <th><?= $venue1Data['name'] ?></th>
                            <th><?= $venue2Data['name'] ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Image</td>
                            <td><img class="venue-image"
                                    src="<?= strtolower(str_replace(" ", "_", $venue1Data["name"])) . ".jpg"; ?>"
                                    alt="<?= $venue1Data['name']; ?>"></td>
                            <td><img class="venue-image"
                                    src="<?= strtolower(str_replace(" ", "_", $venue2Data["name"])) . ".jpg"; ?>"
                                    alt="<?= $venue2Data['name']; ?>"></td>
                        </tr>
                        <tr>
                            <td>Capacity</td>
                            <td><?= $venue1Data['capacity'] ?></td>
                            <td><?= $venue2Data['capacity'] ?></td>
                        </tr>
                        <tr>
                            <td>Weekday Price</td>
                            <td>£<?= $venue1Data['weekday_price'] ?></td>
                            <td>£<?= $venue2Data['weekday_price'] ?></td>
                        </tr>
                        <tr>
                            <td>Weekend Price</td>
                            <td>£<?= $venue1Data['weekend_price'] ?></td>
                            <td>£<?= $venue2Data['weekend_price'] ?></td>
                        </tr>
                        <tr>
                            <td>Rating</td>
                            <td><?= round($venue1Data['average_score'], 1) . '/5' ?></td>
                            <td><?= round($venue2Data['average_score'], 1) . '/5' ?></td>
                        </tr>
                        <tr>
                            <td>Licensed</td>
                            <td><?= $venue1Data['licensed'] == 1 ? 'Yes' : 'No' ?></td>
                            <td><?= $venue2Data['licensed'] == 1 ? 'Yes' : 'No' ?></td>
                        </tr>

                    </tbody>
                </table>
                <section id="comparison-graph">
                    <h2>Price Comparison</h2>
                    <canvas id="comparisonChart"></canvas>
                </section>

            </div>
        <?php endif; ?>
    </form>

    <footer>
        <p>Copyright © 2024 Vows & Venues. All rights reserved.</p>
    </footer>




    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php
    // Encode data for JavaScript
    echo "<script>
var venue1Data = " . json_encode($venue1Data) . ";
var venue2Data = " . json_encode($venue2Data) . ";
</script>";
    ?>

    <script src="compare.js"></script>

</body>

</html>