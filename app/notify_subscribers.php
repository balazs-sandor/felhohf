<?php
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;





function notifySubscribers($description, $peopleCount) {
    include 'db.php';
    $emailserver = getenv('EMAIL_SERVER') ?: 'mail.nethely.hu';
    $emailaddress = getenv('EMAIL_ADDR') ?: 'felhohf@vigyor.hu';
    $emailpassword = getenv('EMAIL_PASS') ?: 'UPeBl7KKbgCHtxoV20szu';

    $result = $conn->query("SELECT email FROM subscriptions");
    while ($row = $result->fetch_assoc()) {
        $mail = new PHPMailer;
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->Host = $emailserver;
        $mail->Port = 465;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;
        $mail->Username = $emailaddress;
        $mail->Password = $emailpassword;
        $mail->setFrom($emailaddress, 'imagedetector');
        $mail->addAddress($row['email'], explode('@', $row['email'])[0]);
        $mail->Subject = "Új kép került feltöltésre!";
        $mail->Body = "Új kép lett feltöltve!\n\nLeírás: $description\nEmberek száma: $peopleCount";

        if (!$mail->send()) {
          echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }
}

?>
