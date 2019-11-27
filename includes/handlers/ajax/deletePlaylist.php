<?php

    include("../../config.php");

    if(isset($_POST['playlistId'])){
        $playlist_id = $_POST['playlistId'];
        $query = mysqli_query($con, "DELETE FROM playlist_track where playlist_id='$playlist_id'");
        $query = mysqli_query($con, "DELETE FROM playlist WHERE playlist_id='$playlist_id'");
    }
    else{
        echo "Playlist not there!";
    }

?>