<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

require __DIR__ . '/vendor/autoload.php';

function generate_6_digit_OTP() {
    $OTP = "";
    for($i = 1; $i <=6; $i++) {
            $int = rand(0,9);
            $str = "$int";
            $OTP .= $str;
    }
	return $OTP;
}

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

$email = $_POST["email"];

$email = filter_var($email, FILTER_SANITIZE_EMAIL);

$mail = new PHPMailer(true);

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
	echo("$email is a valid email address\n");

	$reset_code = generate_6_digit_OTP();
	echo($reset_code);

	try {
	//Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->Port = 587;									//TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
	$mail->SMTPAuth = true;                                   //Enable SMTP authentication

	//Recipients
    $mail->setFrom('zereaux.day@gmail.com', 'Zereaux Day');
    $mail->addAddress($email);

    $mail->Username = env('EMAIL_USERNAME');
    $mail->Password = env('EMAIL_PASSWORD');

    //Attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); 	  //Add attachments

    //Content
    $mail->isHTML(false);                                  //Set email format to HTML
    $mail->Subject = 'Reset Code';
    $mail->Body = "Your one-time password reset code is:\n$reset_code";
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';

	} catch (Exception $e) {
    	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}

	// $msg = "Your one-time password reset code is:\n$reset_code";
	// mail($email,"Reset Code",$msg);
	// echo("Mail should've been sent");

} else {
	echo("$email is not a valid email address");
}

// header("Location:" . "reset_code.html");

?>