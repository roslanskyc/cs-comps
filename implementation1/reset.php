<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// include '/Desktop/cs-comps/.env';

require_once realpath(__DIR__ . '/vendor/autoload.php');

$db = pg_connect("host=localhost dbname=auth user=postgres password=postgres");
if ($db) {echo "connected";}

function generate_6_digit_OTP($db) {
	$unique = false;
	while ($unique != true) {
		$OTP = "";
		for($i = 1; $i <=6; $i++) {
            $int = rand(0,9);
            $str = "$int";
            $OTP .= $str;
    	}
		echo $OTP;
		echo "we're good\n";
		//verifies if OTP has already been used
		$result = pg_query_params($db, "SELECT * FROM otp WHERE code = $1", array($OTP));
		$rows = pg_num_rows($result);
		echo $rows;
		if ($rows == 0) {$unique = true;}
	}
	$OTP = (int)$OTP;
	echo "I have the OTP\n";
	return $OTP;
}

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
// $dotenv->load();
// print_r($_ENV); 

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__); //these lines are problematic
// $dotenv->load();

$email = $_POST["email"];

$email = filter_var($email, FILTER_SANITIZE_EMAIL);

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	// echo("$email is a valid email address\n");

	$reset_code = generate_6_digit_OTP($db);
	// echo($reset_code);

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

	// $mail->Username = $_ENV['EMAIL_USERNAME'];
	// $mail->Password = $_ENV['EMAIL_PASSWORD'];

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Reset Code';
    $mail->Body = "Your one-time password reset code is:\n$reset_code";

    $mail->send();
    echo 'Message has been sent';

	//need to change this for parameter pollution
	$insert = pg_query_params($db, "INSERT INTO otp (code, account) VALUES ($1, $2)", array($reset_code, $email));

	header("Location:" . "reset_code.php");

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