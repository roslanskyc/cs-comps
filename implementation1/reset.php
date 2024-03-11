<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';



$post = file_get_contents('php://input');

//runs python program to check email account and create OTP
$command = escapeshellcmd('/usr/bin/python3 /usr/lib/cgi-bin/email.py ' .$post);
$output = shell_exec($command);

$email = $_POST["email"];

$reset_code = 0;
$temp = pg_query_params($db, "SELECT code FROM otp WHERE account = $1", array($output));
$temporary = pg_fetch_all($temp);

$reset_code = $temporary[0]['code'];
echo $reset_code;

$email = filter_var($email, FILTER_SANITIZE_EMAIL);

if ($email && $reset_code != 0) {
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

	header("Location:" . "reset_code.html");

	} catch (Exception $e) {
    	echo "Message could not be sent.";

		header("Location:" . "reset.html");
		// Mailer Error: {$mail->ErrorInfo}
	}

} else {
	echo("$email is not a valid email address");
	header("Location:" . "reset.html");
}

?>