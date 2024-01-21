<?php

    //include "db_conn.php";

    $username = $password = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return data;
        }

        
    }
    
    $username = validate($_POST["user"]);
    $password = validate($_POST["pass"]);


if(empty($username)){
    header ("Location: register.html?erro=Username is required");
    exit();
}
else if(empty($pass)){
    header ("Location: register.html?erro=Password is required");
    exit();
}


