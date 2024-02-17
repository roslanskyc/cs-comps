<?php
session_start();
if($_SESSION['username'] == "cjr"){
    echo "yay";
} else {
    echo ":(";
    echo $_SESSION['username'];
}

?>