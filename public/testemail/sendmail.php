<?php
require 'PHPMailerAutoload.php';
require 'class.phpmailer.php';


$mail = new PHPMailer;

$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.sendgrid.net';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'apikey';                 // SMTP username
$mail->Password = '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';                           // SMTP password
//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->From = 'help@wingifts.net';
//$mail->FromName = 'Mailer';
$mail->FromName = '';
$mail->addAddress('thenoone18@gmail.com', 'Stan');  // Add a recipient

$mail->isHTML(true);                                // Set email format to HTML

$mail->Subject = "subbbb";
$mail->Body    = "boddddy";
$mail->AltBody = "boddddy2";

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}