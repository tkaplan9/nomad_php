<?php
    include 'dbconfig.php';
    
    // Creating connection.
    $con = mysqli_connect($hostname,$dbuname,$password,$dbname);
    // Getting the received JSON into $json variable.
    $json = file_get_contents('php://input');
    // decoding the received JSON and store into $obj variable.
    $obj = json_decode($json,true);
    $deneme = "b0bc28d2e7f248049b8be8a27142ca65";
    $stmt = "Select Trip.TripID, Trip.UserID, name, label, description, rating From ".$dbuname.".FinishedRoutes, ".$dbuname.".Trip Where FinishedRoutes.UserID = '".$obj["guid"]."' AND FinishedRoutes.TripID = Trip.TripID";
    $result = mysqli_query($con, $stmt);
    $tripJSON;
    if(mysqli_num_rows($result)){
        $tripJSON = "[";
        mysqli_data_seek($result, 0);
        while($row = mysqli_fetch_row($result)){
            $currRow = "{\"tripID\":\"".$row[0]."\",\"userID\":\"".$row[1]."\",\"name\":\"".$row[2]."\", \"label\":\"".$row[3]."\",\"description\":\"".$row[4]."\",\"rating\":\"".$row[5]."\"},";
            $tripJSON = $tripJSON.$currRow;
        }
        $tripJSON = substr_replace($tripJSON,'',-1);
        $tripJSON = $tripJSON."]";
    }else{
        $tripJSON = '[]';
    }
    $tripJSON = stripslashes($tripJSON);
    /*$tripJSON = '{"trips":[{"tripID":"22","userID":"1","name":"Default Trip Name","label":"Default Label","description":"3 Marker trip"}]}';*/
    
    $error = mysqli_error($con);
    
    echo json_encode([ "result" => 1, "trips" => $tripJSON, "error" => $error ]); //return result -1 if unsuccessful
    mysqli_close($con);
    exit(0);
?>