<?php 
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    echo "<p> must use POST method </p>";
    exit();
}

include "dbconn.php";


$username = $_POST["username"];
$password = $_POST["newpassword"];
$oldpassword = $_POST["oldpassword"];
$hashedp = md5($password);
$hashedold = md5($oldpassword);
if(!isset($username) || !isset($password) || !isset($oldpassword)){
    echo "<p>Please fill out all the fields</p>";
    exit();
}

$usercheck = "SELECT * FROM users WHERE username = ? and password = ?";
$sql = "UPDATE users SET password = ? WHERE username = ? and password = ?";


if($statement = mysqli_prepare($connection, $usercheck)){
    mysqli_stmt_bind_param($statement,'ss', $username,$hashedold);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows > 0){
        if($statement = mysqli_prepare($connection, $sql)){
            mysqli_stmt_bind_param($statement,'sss', $hashedp,$username,$hashedold);
            mysqli_stmt_execute($statement);
            echo "<p>Users pass word has been updated</p>";
        }else{
            echo "Error";
        }
    }else{
        echo "<p>username and/or password are invalid.</p>";
    }
    
}else{
    echo "Error";
}
mysqli_close($connection);
?>