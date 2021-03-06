<?php
    include 'dbconfig.php';
    $conn = mysqli_connect($hostname,$dbuname,$password);
    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);
    $searchText = $obj["searchText"];
    $result = mysqli_query($conn,"Select * From ".$dbuname.".Trip Where name Like '%".$searchText."%' Or label Like '%".$searchText."%' Or description Like '%".$searchText."%'");
    if(mysqli_num_rows($result)){
    
        $counter = 0;
        $first = true;
        $row=mysqli_fetch_assoc($result);
        $json = '{"trips":[';
        mysqli_data_seek($result, 0);
        while($row=mysqli_fetch_row($result)){
            $stmt = 'Select AVG(rating) From '.$dbuname.'.FinishedRoutes Where rating Is Not NULL and TripID = '.$row[0].'';
            $resultForRating = mysqli_query($conn, $stmt);
            
            $avg = 0;
            
            $rateRow = mysqli_fetch_row($resultForRating);
            if(mysqli_num_rows($result))
                $avg = $rateRow[0];

            //  cast results to specific data types
            $currRow = '{"tripID":"'.$row[0].'","userID":"'.$row[1].'","name":"'.$row[2].'","label":"'.$row[3].'","description":"'.$row[4].'", "rate":"'.$avg.'"},';
            
            //echo "row[0] = ".$row[0]." avg = ".$avg." avg end"."\r\n";
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