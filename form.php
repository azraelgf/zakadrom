<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$request = json_decode(file_get_contents('php://input'));

$recipients = [
	// 'aner-anton@ya.ru',
	'firstrinat@gmail.com', 
	'Evrass999@yandex.ru',
	'orlovaproduction@gmail.com',
	'zakadromstudio@gmail.com',
];

$mail = new PHPMailer(true);

$subject = 'Заявка с сайта zakadrom4k.ru';
$message = "Новая заявка:\n\n";

$message .= "Имя: {$request->name}\n";
$message .= "Телефон: {$request->phone}\n\n";

$secret = include(__DIR__ . '/secret.php');

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP(); 
	$mail->CharSet    = 'UTF-8';                                           //Send using SMTP
    $mail->Host       = 'smtp.jino.ru';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'hello@zakadrom4k.ru';                     //SMTP username
    $mail->Password   = $secret['password'];                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('hello@zakadrom4k.ru', 'zakadrom4k.ru');

	foreach ($recipients as $recipient) {
		$mail->addAddress($recipient);     //Add a recipient
	}

    //Content
    $mail->isHTML(false);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;

    $mail->send();
	
	echo 'ok';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
