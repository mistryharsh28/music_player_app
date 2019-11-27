<?php

    include("includes/includedFiles.php");

?>

<div class="playlistsContainer">

    <div class="gridViewContainer">
    
        <h2>PLAYLISTS</h2>

        <div class="buttonItems">
        
            <button class="button green" onclick="createPlaylist()">
                NEW PLAYLIST
            </button>

        </div>

        <?php 
            $userid = $userLoggedIn->getUserId();
            $playlistQuery = mysqli_query($con, "SELECT playlist_id FROM playlist WHERE user_id='$userid'");

            if(mysqli_num_rows($playlistQuery) == 0){
                echo "<span class='noResults'>You don't have any playlists yet.</span>";
            }

            while($row = mysqli_fetch_array($playlistQuery)) {
                
                $playlist = new Playlist($con, $row['playlist_id']);

                echo "<div class='gridViewItem' role='link' tabindex='0' onclick='openPage(\"playlist.php?id=". $playlist->getId() ."\")'>

                        <div class='playlistImage'>
                            <img src='assets/images/icons/playlist.png'>
                        </div>

                        <div class='gridViewInfo'> ". 
                            $playlist->getTitle()
                        . "</div>
                    </div>";
            }
        ?>

    </div>

</div>