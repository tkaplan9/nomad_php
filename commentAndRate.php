<?php
    include 'dbconfig.php';
    
    // Creating connection.
    $con = mysqli_connect($hostname,$dbuname,$password,$dbname);
    // Getting the received JSON into $json variable.
    $json = file_get_contents('php://input');
    // decoding the received JSON and store into $obj variable.
    $obj = json_decode($json,true);
    
    $tripID = $obj['tripID'];
    $guid = $obj['guid'];
    $comment = $obj['comment'];
    $rating = $obj['rating'];

    $stmt = "UPDATE ".$dbuname.".FinishedRoutes SET comment = '".$comment."', rating = ".$rating." where UserID = '".$guid."' and TripID = ".$tripID;
    
    $result = mysqli_query($con, $stmt);
    $result2 = mysqli_query($con, "Select * From ".$dbuname.".UserTable Where guid = '".$guid."'");
    $row = mysqli_fetch_row($result2);
    $stmt2 = 'Insert Into '.$dbuname.'.TripComments (Name, Surname, TripID,Comment) Values("'.$row[1].'","'.$row[2].'",'.$tripID.',"'.$comment.'")';
    mysqli_query($con,$stmt2);
    $error = mysqli_error($con);
    
    echo json_encode([ "result" => 1, "error" => $error ]); //return result -1 if unsuccessful
    mysqli_close($con);
    exit(0);
?>