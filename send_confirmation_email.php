<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $venueId = htmlspecialchars($_POST['venueId']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if ($email) {
        $subject = "Your Wedding Venue Booking Confirmation";
        $message = "Thank you for booking your venue with Vows & Venues. Your booking ID is $venueId.";
        $headers = "From: D.Hubble-23@student.lboro.ac.uk"; 

        if (mail($email, $subject, $message, $headers)) {
            echo json_encode(['success' => true, 'email' => $email]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false]);
    }
} else {
    echo json_encode(['success' => false]);
}
