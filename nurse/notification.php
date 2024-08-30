<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../include/header.php");
require 'vendor/autoload.php'; // Path to Composer autoload.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipient_emails = $_POST['recipient_emails']; 
    $message = $_POST['message'];
    $subject = 'Notification from Nurse Dashboard';

    // Check recipient_emails for multiple emails and make it an array.
    if (stristr($recipient_emails, ',')) {
        $recipient_emails = explode(',', $recipient_emails);
    } else {
        $recipient_emails = [$recipient_emails];
    }

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'leeanson3324@gmail.com'; // SMTP username
        $mail->Password = 'imtyycmsivntdjuk'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;


        // Sender info
        $mail->setFrom('leeanson3324@gmail.com', 'Nurse Dashboard');

        // Add recipients
        foreach ($recipient_emails as $email) {
            $mail->addAddress(trim($email));
        }

        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = nl2br($message);

        // Send the email
        $mail->send();
        $notification_status = 'Email sent successfully.';
    } catch (Exception $e) {
        $notification_status = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification - Nurse Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .footer {
            background-color: pink;
            padding: 10px;
            color: white;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            left: 0;
            right: 0;
        }
    </style>
</head>
<body style="background-image: url(img/background1.jpg);background-repeat:no-repeat; background-size:cover;">

<div class="container-fluid">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2" style="margin-left: -30px;">
                <?php
                include("sidenav.php");
                ?>
            </div>
            <div class="col-md-10">
                <div class="container-fluid">
                    <h2 class="my-4">Send Email Notification - Nurse Dashboard</h2>
                    <form method="post">
                        <div class="form-group">
                            <label for="recipient_emails">Recipient Email(s):</label>
                            <input type="text" class="form-control" id="recipient_emails" name="recipient_emails" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message:</label>
                            <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-info">Send Notification</button>
                    </form>
                    <div class="mt-4">
                        <?php if(isset($notification_status)): ?>
                            <div class="alert alert-info" role="alert">
                                <?php echo $notification_status; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
