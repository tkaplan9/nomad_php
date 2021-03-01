<?php
    include 'dbconfig.php';
    
    // Creating connection.
    $con = mysqli_connect($hostname,$dbuname,$password,$dbname);
    // Getting the received JSON into $json variable.
    $json = file_get_contents('php://input');
    // decoding the received JSON and store into $obj variable.
    $obj = json_decode($json,true);
    
    $userJSON = $obj['user'];
    $tripID = $obj['trip'];
    
    $userObj = json_decode($userJSON,true);
    $id = $userObj['userID'];
    $email = $userObj['email'];
    $username = $userObj['username'];
    $password = $userObj['password'];
    $stmt = "Insert Into ".$dbuname.".FinishedRoutes (UserID, TripID) Values(\"".$id."\",".$tripID.")";
    $result = mysqli_query($con, $stmt);
    $error = mysqli_error($con);
    if($result){
        echo json_encode([ "result" => 1, "error" => $error]);
    }
    else{
        echo json_encode([ "result" => -1, "error" => $error]);
    }
    mysqli_close($con);
    exit(0);
?>