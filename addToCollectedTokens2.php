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
    if($do){
        $stmt = "Select TokenNum From ".$dbuname.".TokenNumbers Where UserID = '".$userID."'";
        $result = mysqli_query($conn, $stmt);
        
        $row=mysqli_fetch_row($result);
        $tokenNew = $row[0]+1;
        print("This is fucking token new = ".$tokenNew);
        $stmt = "Update ".$dbuname.".TokenNumbers Set TokenNum = ".$tokenNew." Where UserID='".$userID."'";
        $do = mysqli_query($conn,$stmt);
        
    }
    else
        print("yok amk");
    mysqli_close($conn);

?>