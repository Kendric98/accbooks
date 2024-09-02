<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Check if email is valid
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Save the email to a file or database
        $file = 'subscribers.txt';
        file_put_contents($file, $email . PHP_EOL, FILE_APPEND | LOCK_EX);
        
        // Redirect to a thank you page or show a success message
        echo "Thank you for subscribing!";
    } else {
        // Show an error message if the email is not valid
        echo "Invalid email address.";
    }
} else {
    // Handle the case where the form was not submitted via POST
    echo "No data received.";
}
?>