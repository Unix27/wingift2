<?php
require 'PHPMailerAutoload.php';
require 'class.phpmailer.php';


$mail = new PHPMailer;

$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.esputnik.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'wingifts0001@gmail.com';                 // SMTP username
$mail->Password = '^W!S8dIgafRj12345';                           // SMTP password
//$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->From = 'wingifts0001@gmail.com';
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