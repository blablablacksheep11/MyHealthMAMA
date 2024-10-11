<?php
session_start();
include("include/connection.php");

//retreive the data from ajax
$verificationcode = $_POST["verificationcode"];
$email = $_POST["email"];

$_SESSION["email"] = $email;
$entity = $_SESSION["entity"];

//determine the entity
$sql = "SELECT username FROM $entity WHERE email = '$email'";
$respond = mysqli_query($connect, $sql);
if (mysqli_num_rows($respond) > 0) {
    $name = mysqli_fetch_column($respond);
}

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($name != null) {
    //Load Composer's autoloader
    require 'vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'lamyongqin@gmail.com';                     //SMTP username
        $mail->Password   = 'ucfzomtifelijucq';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('lamyongqin@gmail.com', 'PregnaCare +');
        $mail->addAddress($email, $name);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Password Reset';
        $mail->Body    = "Verification code: <br>$verificationcode<br>$entity";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>