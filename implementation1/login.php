<?php

$user = $_POST['username'];
$pass = hash('sha256', $_POST['pass']);
$db = pg_connect("host=localhost dbname=auth user=postgres password=postgres");

$result = pg_prepare($db, "logcheck", "SELECT * FROM credentials WHERE username = $1 AND password = $2");

$result = pg_execute($bd, "logcheck", array($user, $pass));

echo $result;



?>
