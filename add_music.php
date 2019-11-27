<?php

    include("includes/includedFiles.php");

?>






<div class="gridViewContainer">

    <h1 class="pageHeadingBig">Select the album you want to add to.</h1>

    <div class="buttonItems">
        
        <button class="button green" onclick="createAlbum()">
            NEW ALBUM
        </button>

    </div>

    

    <?php 
        $artist_id = $userLoggedIn->getUserId();
        $albumQuery = mysqli_query($con, "SELECT * FROM album WHERE created_by_artist=$artist_id OR album_id IN (SELECT album_id FROM track WHERE track_id IN (SELECT track_id FROM track_artist WHERE artist_id=$artist_id))");
        while($row = mysqli_fetch_array($albumQuery)) {
            
            $artworkPath = $row['artwork_path'];
            $albumTitle = $row['title'];  
            $albumId = $row['album_id'];  
            
            echo "<div class='gridViewItem'>
                    <span role='link' tabindex='0' onclick='openPage(\"add_to_album.php?id=$albumId\")'>
                        <img src='$artworkPath'>

                        <div class='gridViewInfo'>
                            $albumTitle
                        </div>
                    </span>
                </div>";
        }
    ?>

</div>
