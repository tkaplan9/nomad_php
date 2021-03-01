<?php
    include 'dbconfig.php';
    $conn = mysqli_connect($hostname,$dbuname,$password);
    $result = mysqli_query($conn,"Select * From ".$dbuname.".TripMarkers");
    if(mysqli_num_rows($result)){
    
        $counter = 0;
        $first = true;
        $row=mysqli_fetch_assoc($result);
        $json = '{"markers":[';
        mysqli_data_seek($result, 0);
        while($row=mysqli_fetch_row($result)){
            //  cast results to specific data types
            $currRow = '{"markerID":"'.$row[0].'","tripID":"'.$row[1].'","latitude":"'.$row[2].'","longitude":"'.$row[3].'","text":"'.$row[4].'"},';
            
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