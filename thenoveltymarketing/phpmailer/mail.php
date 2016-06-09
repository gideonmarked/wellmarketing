<?php 
include 'phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer();
$mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';

$mail->Host       = "smtp.gmail.com"; // SMTP server example
$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
$mail->SMTPSecure = 'tls';
$mail->Username   = "nikeriseph@gmail.com"; // SMTP account username example
$mail->Password   = "nikeriseph0726";        // SMTP account password example
$mail->setFrom('nikeriseph@gmail.com', 'Nike Rise PH');
$mail->addAddress('gideonmarkcpacete@gmail.com', 'Gideon Mark Pacete');

$mail->Subject = 'Your Nike Rise Photo!';
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
