<?php

    include("../../config.php");

    if(isset($_POST['title']) && isset($_POST['username']) && isset($_POST['userid'])){
        $title = $_POST['title'];   
        $username = $_POST['username'];   
        $userid = $_POST['userid'];   
    
        $date_created = date("Y-m-d");
    
        $query = mysqli_query($con, "INSERT INTO playlist (playlist_id, title, number_of_tracks, user_id, date_created) VALUES ('', '$title', 0, $userid, '$date_created')");

    
        if($query == false){
            echo 'Playlist already exists for you';
        }

    }
    else {
        echo 'Title or Userid not specified';
    }


?>