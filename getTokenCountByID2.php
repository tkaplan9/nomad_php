<?php
    include 'dbconfig.php';
    $conn = mysqli_connect($hostname,$dbuname,$password);
    $json = file_get_contents("php://input");
    $obj = json_decode($json,true);
    $userID = $obj["userID"];
    $result = mysqli_query($conn,"Select * From ".$dbuname.".TokenNumbers Where UserID = '".$userID."'");
    if(mysqli_num_rows($result)){
        
        $json = '';
        
        while($row=mysqli_fetch_row($result)){
            //  cast results to specific data types
            $currRow = '{"count" : [{"count":"'.$row[1].'"}]}';
            
            $json = $json.$currRow;
        }


    } else {
        $json = '[]';
    }
    stripslashes($json);
    mysqli_close($conn);
    echo json_encode($json);
?>