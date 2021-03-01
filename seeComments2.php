<?php
    include 'dbconfig.php';
    $conn = mysqli_connect($hostname,$dbuname,$password);
    $json = file_get_contents("php://input");
    $obj = json_decode($json,true);
    $tripID = $obj["tripID"];
    $result = mysqli_query($conn,"Select * From ".$dbuname.".TripComments Natural Join ".$dbuname.".FinishedRoutes Natural Join ".$dbuname.".TokenNumbers Where TripID = '".$tripID."' and comment Is Not NULL" );
    if(mysqli_num_rows($result)){
    
        $counter = 0;
        $first = true;
        $row=mysqli_fetch_assoc($result);
        $json = '{"comments":[';
        mysqli_data_seek($result, 0);
        while($row=mysqli_fetch_row($result)){
            //  cast results to specific data types
            $stmtAch = 'Select Name From '.$dbuname.'.Achievements Where TokenNum < '.$row[6].' limit 1';
            $achRow = mysqli_fetch_row(mysqli_query($conn, $stmtAch));
            $ach = "";
            if($achRow == null)
                $ach = "baby";
            else 
                $ach = $achRow[0];
            $currRow = '{"rate":"'.$row[5].'","tokenCount":"'.$row[6].'","name":"'.$row[3].'","surname":"'.$row[4].'","tripID":"'.$row[1].'","comment":"'.$row[2].'", "ach":"'.$ach.'"},';
            
            $json = $json.$currRow;
        }
    $json = substr_replace($json,'',-1);
    $json = $json."]}";
    } else {
        $json = '[]';
    }
    stripslashes($json);
    mysqli_close($conn);
    echo json_encode($json);
?>