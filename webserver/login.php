<?php



if(isset($_POST['username']) && isset($_POST['password'])){

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return data;
    }
}

$username = validate($_POST['username']);
$pass = validate($_POST['password']);

if(empty($username)){
    header ("Location: index.html?erro=Username is required");
    
}
else if(empty($pass)){
    header ("Location: index.html?erro=Password is required");
    
}

header("Authorization: Basic " . base64_encode($_POST['username'] . ":" . $_POST['password']));
if($_POST['username'] == "CEO"){
    header("Account-Type: CEO");
} else {
    header("Account-Type: User");
}
include("landing/land.php");









/*
$sql = "SELECT * FROM users WHERE user_name='$username' AND password='$pass'"

$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) === 1){
    $row = mysqli_fetch_assoc($result);
    if($row['user_name'] === $username && $row['password'] === $pass){
        echo "Logged In!";
        $_SESSION['username'] = $row['user_name'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['id'] = $row['id'];
        header("Location: ?????");
        exit();
    }
}
else{
    header("Location: index.html");
    exit();
}
