<?php
// Recaptcha Settings
$recaptcha_secret = '6Ldr0BctAAAAAKHa9c-cg7w63-u5fI9iza9NVeug';

// Email Settings
$to = "info@thoyiwaglobaltech.co.za"; 
$subject = "New Website Enquiry";

// Verify Recaptcha
$recaptcha_token = $_POST['recaptcha_token'] ?? '';
if (empty($recaptcha_token)) {
    die("reCAPTCHA token missing. Please try again.");
}

$verify_response = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $recaptcha_secret . '&response=' . $recaptcha_token);
$response_data = json_decode($verify_response);

if (!$response_data->success || $response_data->score < 0.5) {
    die("Bot activity detected. If you are human, please contact us directly via email.");
}

// Process Form Data
$sender_name = htmlspecialchars($_POST['f_name'] ?? 'Unknown');
$from = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars($_POST['phone'] ?? '');
$service = htmlspecialchars($_POST['service'] ?? 'Not specified');
$note = htmlspecialchars($_POST['note'] ?? '');

$message = "You have received a new enquiry from the website.\n\n";
$message .= "Name: " . $sender_name . "\n";
$message .= "Email: " . $from . "\n";
$message .= "Phone: " . $phone . "\n";
$message .= "Service Requested: " . $service . "\n";
$message .= "Message/Description:\n" . $note . "\n";

$headers = "From: " . $to . "\r\n"; // Send from own domain to avoid spam filters
$headers .= "Reply-To: " . $from . "\r\n";

if(mail($to, $subject, $message, $headers)) {
    echo "success";
} else {
    echo "Failed to send email. Please try again.";
}
?>