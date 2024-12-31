<?php

$to = 'avatarwebsites@gmail.com'; // Replace with the recipient's email address
$subject = 'Cron Job Test Email'; // Subject of the email
$message = 'This is a test email sent from a cron job.'; // Body of the email
$headers = 'From: design@avatarprints.com' . "\r\n" . // Replace with the sender's email address
           'Reply-To: design@avatarprints.com' . "\r\n" . // Optional: Replace with the sender's email address
           'X-Mailer: PHP/' . phpversion(); // Email headers

mail($to, $subject, $message, $headers);
?>
