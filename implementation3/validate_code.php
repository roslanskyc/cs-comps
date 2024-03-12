<?php
session_start();


$reset_code = $_POST["reset_code"];

$email = pg_query_params($db, "SELECT account FROM otp WHERE code = $1", array($reset_code));
$rows = pg_num_rows($email);
$acct = pg_fetch_all($email)[0]["account"];
$type = gettype($email);

pg_query_params($db, "DELETE FROM otp WHERE code =$1", array($reset_code));

if ($rows == 1) {
	// set session cookie saying can reset password
    $_SESSION['canRestart'] = 'T';
	$_SESSION['username'] = $acct;
	header("Location: newpass.html");
} else {
	header("Location: reset_code.html");
}
?>