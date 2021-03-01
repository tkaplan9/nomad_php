<?php
    include 'dbconfig.php';
    
    //connection
    $conn = mysqli_connect($hostname,$dbuname,$password);


    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);
    $tripID = $obj["tripID"];
    $lat = $obj["latitude"];
    $long = $obj["longitude"];
    $text = $obj["text"];
    
    $stmt = "Insert Into ".$dbuname. ".TripMarkers (tripID, latitude, longitude, text) Values ('".$tripID."','".$lat."','".$long."','".$text."');";
    
    $do = mysqli_query($conn, $stmt);
    mysqli_close($conn);
    print("here")

?>