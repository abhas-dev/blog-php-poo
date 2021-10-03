<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception as PHPMailerException;


$mail = new PHPMailer(true);
$mail->setLanguage('fr');

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'localhost';                     //Set the SMTP server to send through
//    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//    $mail->Username   = 'user@example.com';                     //SMTP username
//    $mail->Password   = 'secret';                               //SMTP password
//    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 8085;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Charset
    $mail->CharSet = "utf-8";

    // Expediteur
    $mail->setFrom('contact@myblog.com', 'Abdelatif');

    // Destinataire
    $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
//    $mail->addCC('cc@example.com'); // Add copy
//    $mail->addBCC('bcc@example.com'); //copie cachée

//    //Attachments
//    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
} catch (PHPMailerException $e) {
    echo "Le message n'a pas pu etre envoyé. Erreur: {$mail->ErrorInfo}";

}