<?php

$user = $_POST['username'];
$pass = hash('sha256', $_POST['pass']);
$db = pg_connect("host=localhost dbname=auth user=postgres password=postgres");


$result = pg_query_params($db, "SELECT * FROM credentials WHERE username = $1 AND password = $2", array($user, $pass));

$rows = pg_num_rows($result);

if($rows == 1){
    $_SESSION['username'] = $username;
    header("Location: home.php");
    exit();

} else {
    echo "<div class='form'>
<h3>Username/password is incorrect.</h3>
<br/>Click here to <a href='index.html'>Login</a></div>";
}



?>
