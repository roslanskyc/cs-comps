<?php
session_start();
$db = pg_connect("host=localhost dbname=auth user=postgres password=postgres");

$reset_code = $_POST["reset_code"];

$email = pg_query_params($db, "SELECT account FROM otp WHERE code = $1", array($reset_code));
$rows = pg_num_rows($email);

$type = gettype($email);

pg_query_params($db, "DELETE FROM otp WHERE code =$1", array($reset_code));

if ($rows == 1) {
	// set session cookie saying can reset password
    $_SESSION['canRestart'] = 'T';
	header("Location: newpass.html");
} else {
	header("Location: reset_code.html");
}
?>