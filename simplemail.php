<?php
// Retrieve form data
$name = 'name';
$email = 'saravanaperumal768@gmail.com';
$mobile = '9787951522';
// $city = $_POST['c_city'];
// $address = $_POST['c_address'];
// $mes = $_POST['content'];
// $subTotal = $_POST['sub_total'];
// $discountPrice = $_POST['discount'];
// $overallTotal = $_POST['overall-total'];

// Compose the email message
$message = "Name: $name\n";
$message .= "Email: $email\n";
$message .= "Mobile: $mobile\n";
// $message .= "City: $city\n";
// $message .= "Address: $address\n";
// $message .= "Message: $mes\n";
// $message .= "Sub Total: $subTotal\n";
// $message .= "Discount Price: $discountPrice\n";
// $message .= "Overall Total: $overallTotal\n";

// Set email parameters
$to = 'solverssoftech@gmail.com';  // Replace with the actual recipient email address
$subject = 'New Order Details';
$headers = 'From: '.$email;  // Replace with the actual sender email address
$headers .= "\r\n" . 'Reply-To: ' . $email;

// Send the email
$mailSuccess = mail($to, $subject, $message, $headers);

// Check if the email was sent successfully
if ($mailSuccess) {
    echo 'Email sent successfully!';
} else {
    echo 'Error: Unable to send email.';
}
?>
