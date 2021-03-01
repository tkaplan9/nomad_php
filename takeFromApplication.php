<?php
    include 'dbconfig.php';
    
    //connection
    $conn = mysqli_connect($hostname,$dbuname,$password);


    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);
    $name = $obj["username"];
    $email = $obj["email"];

    $stmt = "Insert Into fOopXz0KPv.Trial (username, password) Values ('".$name."','".$email."');";
    
    $do = mysqli_query($conn, $stmt);
    mysqli_close($conn);
    print("here")

?>