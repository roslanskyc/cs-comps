<?php

if($_POST['username'] != "Guest" || $_POST['pass'] != "Guest"){
        exit();
}
if($_POST['username'] == "CEO"){
    setcookie("Account-Type"," CEO");
} else {
    setcookie("Account-Type", "User");
}

header("Location:" . "land.php");

?>
