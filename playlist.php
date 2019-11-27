<?php include("includes/includedFiles.php"); 

    if (isset($_GET['id'])){
        $playlistId = $_GET['id'];
    }
    else{
        header("Location: index.php");
    }

    $playlist = new Playlist($con, $playlistId);
    $owner = new User($con, $playlist->getUserId());

?>

<div class="entityInfo">
    <div class="leftSection">
        <div class="playlistImage">
            <img src="assets/images/icons/playlist.png" alt="Artwork">
        </div>
    </div>
    <div class="rightSection">
        <h2><?php echo $playlist->getTitle(); ?></h2>
        <p>By <?php echo $owner->getName(); ?></p>
        <p><?php echo $playlist->getNumberOfTracks(); ?> songs</p>
        <button class="button" onclick="deletePlaylist(<?php echo $playlistId; ?>)">DELETE PLAYLIST</button>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?php
            $songIdArray = $playlist->getSongIds();

            $i = 1;

            foreach($songIdArray as $songId){

                $playlistTrack = new Track($con, $songId);
                $trackTitle = $playlistTrack->getTitle();
                $trackArtists = $playlistTrack->getArtists();
                $trackDuration = $playlistTrack->getDuration();
                $trackId = $playlistTrack->getId();

                echo "
                    <li class='tracklistRow'>
                        <div class='trackCount'>
                            <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $trackId . "\", tempPlaylist, true)'>
                            <span class='trackNumber'>$i</span>
                        </div>

                        <div class='trackInfo'>
                            <span class='trackName'>$trackTitle</span>
                            <span class='artistName'>$trackArtists</span>
                        </div>

                        <div class='trackOptions'>
                            <input type='hidden' class='songId' value='$trackId'>
                            <img class='optionButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                        </div>

                        <div class='trackDuration'>
                            <span class='duration'>$trackDuration</span>
                        </div>

                    </li>
                
                ";

                $i = $i + 1;
            }
        ?>

        <script>
            var tempTrackIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempTrackIds);
        </script>

    </ul>
</div>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUserId()); ?>
    <div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId; ?>')">
        Remove from Playlist
    </div>
</nav>

