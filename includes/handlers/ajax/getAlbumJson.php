<?php
    
    include("../../config.php");

    if(isset($_POST['albumId'])){
        $albumId = $_POST['albumId'];

        $query = mysqli_query($con, "SELECT * FROM album WHERE album_id='$albumId'");
        $album = mysqli_fetch_array($query);

        echo json_encode($album);
    }

?>