<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';


<<<<<<< HEAD
=======

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
>>>>>>> 2395b8c0dfebafa64cc670d5c46a97407ccc1ea4

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

<<<<<<< HEAD
if ($email && $reset_code != 0) {
=======
if (filter_var($email, FILTER_VALIDATE_EMAIL) && $reset_code != 0) {

>>>>>>> 2395b8c0dfebafa64cc670d5c46a97407ccc1ea4
	try {
	//Server settings
	$mail = new PHPMailer(true);
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;             //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'smtp-pulse.com';                     //Set the SMTP server to send through
    $mail->Port = 587;									//465 TCP port to connect to;
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //ENCRYPTION_SMTPS ENCRYPTION_STARTTLS Enable implicit TLS encryption
	$mail->SMTPAuth = true;                                   //Enable SMTP authentication

	//Recipients
    $mail->setFrom('borlaka@carleton.edu', 'Zero Day');
    $mail->addAddress($email);
<<<<<<< HEAD

=======
	echo $email;
>>>>>>> 2395b8c0dfebafa64cc670d5c46a97407ccc1ea4
	

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Reset Code';
    $mail->Body = "Your one-time password reset code is:\n$reset_code";

    $mail->send();
    echo 'Message has been sent';

<<<<<<< HEAD
=======
	//need to change this for parameter pollution
	

>>>>>>> 2395b8c0dfebafa64cc670d5c46a97407ccc1ea4
	header("Location:" . "reset_code.html");

	} catch (Exception $e) {
    	echo "Message could not be sent.";

		header("Location:" . "reset.html");
	}

} else {
	echo("$email is not a valid email address");
	header("Location:" . "reset.html");
}

?>