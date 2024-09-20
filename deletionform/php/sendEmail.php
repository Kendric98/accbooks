<?php

// Replace this with your own email address
$to = info@myaccuratebook.com;

function url(){
    return sprintf(
        "%s://%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME']
    );
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Ensure required fields are set and sanitized
    $name = isset($_POST['name']) ? trim(stripslashes($_POST['name'])) : '';
    $email = isset($_POST['email']) ? trim(stripslashes($_POST['email'])) : '';
    $phone = isset($_POST['phone']) ? trim(stripslashes($_POST['phone'])) : '';
    $contact_message = isset($_POST['message']) ? trim(stripslashes($_POST['message'])) : '';

    if ($name == '' || $email == '' || $contact_message == '') {
        echo "Please fill in all required fields.";
        exit;
    }

    // Fallback subject if phone is not provided
    $subject = $phone != '' ? $phone : "Contact Form Submission";

    // Set Message (initialize the message before concatenating)
    $message = "";
    $message .= "Email from: " . htmlspecialchars($name) . "<br />";
    $message .= "Email address: " . htmlspecialchars($email) . "<br />";
    $message .= "Message: <br />";
    $message .= nl2br(htmlspecialchars($contact_message));
    $message .= "<br /> ----- <br /> This email was sent from your site " . url() . " contact form. <br />";

    // Set From: header
    $from = $name . " <" . $email . ">";

    // Email Headers
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: ". $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    // Check for email validity
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Send the email
    ini_set("sendmail_from", $to); // For windows server
    $mail = mail($to, $subject, $message, $headers);

    // Check if mail was sent successfully
    if ($mail) { 
        echo "OK"; 
    } else { 
        echo "Something went wrong. Please try again."; 
        error_log("Mail error: Failed to send email from contact form");
    }

}

?>
