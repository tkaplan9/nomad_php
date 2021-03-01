<?php
    include 'dbconfig.php';
    $conn = mysqli_connect($hostname,$dbuname,$password);
    $json = file_get_contents("php://input");
    $obj = json_decode($json,true);
    $result = mysqli_query($conn,"Select * From ".$dbuname.".TripComments Where TripID = '".$obj["tripID"]."'" );
    if(mysqli_num_rows($result)){
    
        $counter = 0;
        $first = true;
        $row=mysqli_fetch_assoc($result);
        $json = '{"comments":[';
        mysqli_data_seek($result, 0);
        while($row=mysqli_fetch_row($result)){
            //  cast results to specific data types
            $currRow = '{"name":"'.$row[0].'","surname":"'.$row[1].'","tripID":"'.$row[2].'","comment":"'.$row[3].'"},';
            
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