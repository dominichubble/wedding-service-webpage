
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $message = sanitize_input($_POST['message']);
    $contact_data = "Name: " . $name . "\nEmail: " . $email . "\nMessage: " . $message . "\n---\n";
    $file = 'contacts.txt';
    file_put_contents($file, $contact_data, FILE_APPEND | LOCK_EX);
    echo "Thank you for your message!";
} else {
    echo "Error: Data was not submitted correctly.";
}

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

