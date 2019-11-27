<?php include("includes/includedFiles.php"); 

    if (isset($_GET['id'])){
        $albumId = $_GET['id'];
    }
    else{
        header("Location: index.php");
    }

    $album = new Album($con, $albumId);
    $created_by_artist = $album->getCreatedByArtist();
    $created_by_artist_id = $created_by_artist->getId();
?>

<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath(); ?>" alt="Artwork">
    </div>
    <div class="rightSection">
        <h2><?php echo $album->getTitle(); ?></h2>
        <p role="link" tabindex="0" onclick=<?php echo "openPage('artist.php?id=$created_by_artist_id')";?> >By <?php echo $created_by_artist->getName(); ?></p>
        <p><?php echo $album->getNumberOfTracks(); ?> songs</p>
    </div>
</div>

<div class="tracklistContainer">
    <ul class="tracklist">
        <?php
            $songIdArray = $album->getSongIds();

            $i = 1;

            foreach($songIdArray as $songId){

                $albumTrack = new Track($con, $songId);
                $trackTitle = $albumTrack->getTitle();
                $trackArtists = $albumTrack->getArtists();
                $trackDuration = $albumTrack->getDuration();
                $trackId = $albumTrack->getId();

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
</nav>