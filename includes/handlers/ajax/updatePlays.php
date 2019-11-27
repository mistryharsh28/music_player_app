<?php
    
    include("../../config.php");

    if(isset($_POST['trackId'])){
        $trackId = $_POST['trackId'];

        $query = mysqli_query($con, "UPDATE track SET plays = plays + 1 WHERE track_id='$trackId'");
    }

?>