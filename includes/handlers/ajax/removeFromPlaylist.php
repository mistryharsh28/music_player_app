<?php

    include("../../config.php");

    if(isset($_POST['playlistId']) && isset($_POST['songId'])){
        $playlist_id = $_POST['playlistId'];
        $song_id = $_POST['songId'];
        $query = mysqli_query($con, "DELETE FROM playlist_track WHERE playlist_id='$playlist_id' AND track_id='$song_id'");
        $query = mysqli_query($con, "UPDATE playlist SET number_of_tracks=number_of_tracks-1 WHERE playlist_id='$playlist_id'");
    }
    else{
        echo "Playlist or song not there!";
    }

?>