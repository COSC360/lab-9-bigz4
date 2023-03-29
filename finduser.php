<?php 
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    echo "<p> must use POST method </p>";
    exit();
}

include "dbconn.php";

$username = $_POST["username"];

if(!isset($username)){
    echo "<p>Please fill out all the fields</p>";
    exit();
}

$usercheck = "SELECT * FROM users WHERE username = ?";

if($statement = mysqli_prepare($connection, $usercheck)){
    mysqli_stmt_bind_param($statement,'s', $username);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    if($result->num_rows > 0){
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        echo "<fieldset><legend>User: $username</legend>";
        echo "<table id=\"usertable\">";
        echo "<tr><td>First Name:</td><td>".$row['firstName']."</td></tr>";
        echo "<tr><td>Last Name:</td><td>".$row['lastName']."</td></tr>";
        echo "<tr><td>Email:</td><td>".$row['email']."</td></tr>";
        echo "</table>";
        echo "</fieldset>";
    }else{
        echo "<p>username and/or password are invalid.</p>";
    }
    
}else{
    echo "Error";
}
mysqli_close($connection);
?>