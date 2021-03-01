<?php
    include 'dbconfig.php';
    $conn = mysqli_connect($hostname,$dbuname,$password);
    $json = file_get_contents("php://input");
    $userID = $json["userID"];
    $result = mysqli_query($conn,"Select Name From ".$dbuname.".Achievements Where UserID = '".$userID."'");
    if(mysqli_num_rows($result)){
    
        $counter = 0;
        $first = true;
        $row=mysqli_fetch_assoc($result);
        $json = "";
        mysqli_data_seek($result, 0);
        while($row=mysqli_fetch_row($result)){
            //  cast results to specific data types
            $currRow = '{"count":"'.$row[0].'"}';
            
            $json = $json.$currRow;
        }


    } else {
        $json = '[]';
    }
    stripslashes($json);
    mysqli_close($conn);
    echo json_encode($json);
?>