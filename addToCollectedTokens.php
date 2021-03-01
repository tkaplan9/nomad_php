<?php
    include 'dbconfig.php';
    
    //connection
    $conn = mysqli_connect($hostname,$dbuname,$password);


    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);
    $userID = $obj["userID"];
    $tripID = $obj["tripID"];
    $markerID = $obj["markerID"];



    $stmt = "Insert Into ".$dbuname.".CollectedTokens (UserID, TripID, MarkerID) Values ('".$userID."',".$tripID.",".$markerID.");";
    
    $do = mysqli_query($conn, $stmt);
    $json = "{[]}";
    echo json_encode($json,true);
    mysqli_close($conn);
    print("here")

?>