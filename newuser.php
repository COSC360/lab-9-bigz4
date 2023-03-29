<?php
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    echo "<p> must use POST method </p>";
    exit();
}

include "dbconn.php";
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$username = $_POST["username"];
$email = $_POST["email"];
$password = $_POST["password"];
$hashedp = md5($password);
if(!isset($firstname) || !isset($lastname) || !isset($username) || !isset($email) || !isset($password)){
    echo "<p>Please fill out all the fields</p>";
    exit();
}
$usercheck = "SELECT * FROM users WHERE username = ? or email = ?";
$sql = "INSERT INTO users VALUES (?,?,?,?,?)";


if($statement = mysqli_prepare($connection, $usercheck)){
    mysqli_stmt_bind_param($statement,'ss', $username,$email);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows > 0){
        echo "<p>error user name or email already in use.</p>";
        echo "<a href='lab9-1.html'>Return to user entry</a>";
        exit();
    }
    
}else{
    echo "Error";
}


if($statement = mysqli_prepare($connection, $sql)){
    mysqli_stmt_bind_param($statement,'sssss', $username,$firstname,$lastname,$email,$hashedp);
    mysqli_stmt_execute($statement);
    echo "<p>Account for the user ".$username." has been created</p>";
}else{
    echo "Error";
}
mysqli_close($connection);
?>
