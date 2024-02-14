<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// include '/Desktop/cs-comps/.env';

require_once realpath(__DIR__ . '/vendor/autoload.php');

// require __DIR__ . '/vendor/autoload.php';

function generate_6_digit_OTP() {
    $OTP = "";
    for($i = 1; $i <=6; $i++) {
            $int = rand(0,9);
            $str = "$int";
            $OTP .= $str;
    }
	return $OTP;
}

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
// $dotenv->load();

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__); //these lines are problematic
// $dotenv->load();

$email = $_POST["email"];

$email = filter_var($email, FILTER_SANITIZE_EMAIL);

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	echo("$email is a valid email address\n");

	$reset_code = generate_6_digit_OTP();
	echo($reset_code);

	try {
	//Server settings
	$mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'smtp-pulse.com';                     //Set the SMTP server to send through
    $mail->Port = 587;									//465 TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //ENCRYPTION_SMTPS ENCRYPTION_STARTTLS Enable implicit TLS encryption
	$mail->SMTPAuth = true;                                   //Enable SMTP authentication

	//Recipients
    $mail->setFrom('borlaka@carleton.edu', 'Zero Day');
    $mail->addAddress($email);

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Reset Code';
    $mail->Body = "Your one-time password reset code is:\n$reset_code";

    $mail->send();
    echo 'Message has been sent';

	} catch (Exception $e) {
    	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}

} else {
	echo("$email is not a valid email address");
}

// header("Location:" . "reset_code.html");

?>