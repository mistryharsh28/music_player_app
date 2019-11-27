<?php

    include("../../config.php");

    if(!isset($_POST['username'])){
        echo 'Error';
        exit();
    }

    if(!isset($_POST['title']) || !isset($_POST['genre']) || !isset($_POST['duration']) || !isset($_POST['albumId'])){
        echo "Not all fields are set";
        exit();
    }

    if(!isset($_FILES['track'])){
        $duration = $_POST['duration'];
        echo $duration;
        echo "Something wrong with track";
        exit();
    }

    if($_POST['title'] == "" || $_POST['genre'] == "" || $_POST['duration'] == ""){
        echo "Please fill all fields";
        exit();
    }

    $title = $_POST['title'];
    $track = $_FILES['track'];
    $genre = $_POST['genre'];
    $duration = $_POST['duration'];
    $albumId = $_POST['albumId'];

    function getRandomName($n) { 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
        $randomString = ''; 

        for ($i = 0; $i < $n; $i++) { 
            $index = rand(0, strlen($characters) - 1); 
            $randomString .= $characters[$index]; 
        } 
      
        return $randomString; 
    }

    $randomTitle = getRandomName(16);

    $success = move_uploaded_file($track['tmp_name'], "../../../assets/music/$randomTitle.mp3");
    if($success == true){

        // get album_order
        $query = mysqli_query($con, "SELECT MAX(album_order) as max_album_order FROM track WHERE album_id=$albumId");
        $albumOrder = mysqli_fetch_array($query)['max_album_order'];
        $albumOrder = $albumOrder + 1;

        // get genre 
        $query = mysqli_query($con, "SELECT genre_id FROM genre WHERE name like '$genre'");
        if(mysqli_num_rows($query) > 0){
            $genre_id = mysqli_fetch_array($query)['genre_id'];
        }
        else{
            $query1 = mysqli_query($con, "INSERT INTO genre (name) VALUES ('$genre')");
            $query2 = mysqli_query($con, "SELECT genre_id FROM genre WHERE name like '$genre'");
            if(mysqli_num_rows($query2) > 0){
                echo 'dfghjk';
                $genre_id = mysqli_fetch_array($query2)['genre_id'];
            }
        }

        $path = "assets/music/$randomTitle.mp3";
        echo 'Upload Success';
        $query = mysqli_query($con, "INSERT INTO track (title, album_id, genre, duration, path, album_order, plays) VALUES ('$title', $albumId, $genre_id, '$duration', '$path', $albumOrder, 0)");
    
        // get track_id and artist id
        $query = mysqli_query($con, "SELECT track_id FROM track WHERE path='$path'");
        $track_id = mysqli_fetch_array($query)['track_id'];

        $username = $_POST['username'];
        $query = mysqli_query($con, "SELECT id FROM user WHERE username='$username'");
        $artist_id = mysqli_fetch_array($query)['id'];


        $query = mysqli_query($con, "INSERT INTO track_artist (artist_id, track_id) VALUES ('$artist_id', '$track_id')");
        echo "Track uploaded";
    }
    else{
        echo 'Upload Fail';
    }

?>