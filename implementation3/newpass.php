<?php
    session_start();
    
    if($_SESSION['canRestart'] != 'T'){
        header("Location: login.php");
        exit();
    }

    $_SESSION['canRestart'] = 'F';

    $user = $_SESSION['username'];
    $pass = hash('sha256', $_POST['pass']);
    $db = pg_connect("host=localhost dbname=auth user=postgres password=postgres");


    $result = pg_query_params($db, "UPDATE credentials SET password = $2 WHERE username = $1;", array($user, $pass));

    header("Location: login.php");
    exit();

?>

