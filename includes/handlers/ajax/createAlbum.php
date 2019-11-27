<?php

    include("../../config.php");

    if(isset($_POST['title']) && isset($_POST['username']) && isset($_POST['userid'])){
        $title = $_POST['title'];   
        $username = $_POST['username'];   
        $userid = $_POST['userid'];   
    
        $query = mysqli_query($con, "INSERT INTO album (title, genre, number_of_tracks, artwork_path, created_by_artist) VALUES ('$title', 3, 0, 'assets/images/artwork/spider-man-into-the-spider-verse.jpg', $userid)");

    
        if($query == false){
            echo 'Album already exists for you';
        }

    }
    else {
        echo 'Title or Userid not specified';
    }


?>