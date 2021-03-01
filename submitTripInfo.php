<?php
    include 'dbconfig.php';
    
    //connection
    $conn = mysqli_connect($hostname,$dbuname,$password);


    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);
    $userID = $obj["userID"];
    $name = $obj["name"];
    $label = $obj["label"];
    $desc = $obj["description"];


    $stmt = "Insert Into ".$dbuname.".Trip (userID, name, label, description) Values ('".$userID."','".$name."','".$label."','".$desc."');";
    
    $do = mysqli_query($conn, $stmt);
    $json = "{[]}";
    echo json_encode($json,true);
    mysqli_close($conn);
    print("here")

?>