<?php

    include("includes/includedFiles.php");

    if (isset($_GET['id'])){
        $albumId = $_GET['id'];
    }
    else{
        header("Location: index.php");
    }

    $album = new Album($con, $albumId);
    if(!$album->checkArtistRightsToAlbum($userLoggedIn->getUserId())){
        header("Location: index.php");
    }

?>

<div class="userDetails">

    <div class="container">
        <h2>Add Music</h2>
        <input type="text" name="title" class="title" placeholder="Track Title">
        <input type="text" name="genre" class="genre" placeholder="Genre">
        <!-- <input type="text" name="duration" class="duration" placeholder="Duration e.g. 4:30 "> -->
        <input type="file" name="track" class="track_file">
        <span class="message"></span>
        <button class="button" onclick="addTrack('title', 'genre', 'track_file', <?php echo $albumId; ?>)">Add Track</button>
    </div>

</div>