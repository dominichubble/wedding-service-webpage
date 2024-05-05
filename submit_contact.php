<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assign and sanitize input data
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $message = sanitize_input($_POST['message']);

    // Prepare the data to be written
    $contact_data = "Name: " . $name . "\nEmail: " . $email . "\nMessage: " . $message . "\n---\n";

    // File to write to
    $file = 'contacts.txt';

    // Open the file and append the data
    file_put_contents($file, $contact_data, FILE_APPEND | LOCK_EX);

    // Redirect or inform the user after submission
    echo "Thank you for your message!";
} else {
    // Handle incorrect method gracefully
    echo "Error: Data was not submitted correctly.";
}

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

