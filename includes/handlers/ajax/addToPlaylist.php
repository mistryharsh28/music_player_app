<?php
    include("../../config.php");

    if(isset($_POST['playlistId']) && isset($_POST['songId'])){
        $playlist_id = $_POST['playlistId'];
        $song_id = $_POST['songId'];
        $query = mysqli_query($con, "SELECT MAX(playlist_order) + 1 as next_order from playlist_track WHERE playlist_id='$playlist_id'");
        $order = mysqli_fetch_array($query)['next_order'];

        $query = mysqli_query($con, "INSERT INTO playlist_track (track_id, playlist_id, playlist_order) VALUES ('$song_id', '$playlist_id', '$order')");
    }
    else{
        echo "Playlist or song not there!";
    }
?>