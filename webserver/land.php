<?php
$cookie = "User";
if(isset($_COOKIE['Account-Type'])) {
        $cookie = $_COOKIE['Account-Type'];
}
if($cookie == "CEO"){
        include("admin.php");
} else {
        include("home.html");
}
?>
