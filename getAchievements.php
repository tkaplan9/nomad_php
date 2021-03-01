<?php
    include 'dbconfig.php';
    $conn = mysqli_connect($hostname,$dbuname,$password);
    $result = mysqli_query($conn,"Select * From ".$dbuname.".Achievements");
    if(mysqli_num_rows($result)){
    
        $counter = 0;
        $first = true;
        $row=mysqli_fetch_assoc($result);
        $json = '{"achievements":[';
        mysqli_data_seek($result, 0);
        while($row=mysqli_fetch_row($result)){
            //  cast results to specific data types
            $currRow = '{"ach_id":"'.$row[0].'","name":"'.$row[1].'","ach_desc":"'.$row[2].'","token":"'.$row[3].'"},';
            
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