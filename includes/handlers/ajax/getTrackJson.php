<?php
    
    include("../../config.php");

    if(isset($_POST['trackId'])){
        $trackId = $_POST['trackId'];

        $query = mysqli_query($con, "SELECT * FROM track WHERE track_id='$trackId'");
        $resultArray = mysqli_fetch_array($query);
        
        echo json_encode($resultArray);
    }

?>