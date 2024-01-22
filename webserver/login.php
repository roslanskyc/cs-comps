<?php



// if(isset($_POST['username']) && isset($_POST['pass'])){

//     function validate($data){
//         $data = trim($data);
//         $data = stripslashes($data);
//         $data = htmlspecialchars($data);
//         return data;
//     }
// }

// $username = validate($_POST['username']);
// $pass = validate($_POST['pass']);

// if(empty($username)){
//     header ("Location: index.html?erro=Username is required");
    
// }
// else if(empty($pass)){
//     header ("Location: index.html?erro=Password is required");
    
// }

header("Authorization: Basic " . base64_encode($_POST['username'] . ":" . $_POST['pass']));
if($_POST['username'] == "CEO"){
    header("Account-Type: CEO");
} else {
    header("Account-Type: User");
}

include("landing/land.php");




?>