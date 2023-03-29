<?php 
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    echo "<p> must use POST method </p>";
    exit();
}

include "dbconn.php";

$username = $_POST["username"];
$password = $_POST["password"];
$hashedp = md5($password);
if(!isset($username) || !isset($password)){
    echo "<p>Please fill out all the fields</p>";
    exit();
}

$usercheck = "SELECT * FROM users WHERE username = ? and password = ?";

if($statement = mysqli_prepare($connection, $usercheck)){
    mysqli_stmt_bind_param($statement,'ss', $username,$hashedp);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows > 0){
        echo "<p>user has a valid account</p>";
    }else{
        echo "<p>username and/or password are invalid.</p>";
    }
    
}else{
    echo "Error";
}
mysqli_close($connection);
?>