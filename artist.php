<?php

    include("includes/includedFiles.php");

    if (isset($_GET['id'])){
        $artistId = $_GET['id'];
    }
    else{
        header("Location: index.php");
    }

    $artist = new Artist($con, $artistId);
?>

<div class="entityInfo borderBottom">
    <div class="centerSection">
        <div class="artistInfo">
            <h1 class="artistName"><?php echo $artist->getName(); ?></h1>
            <div class="headerButtons">
                <button class="button green" onclick="playFirstSong()">PLAY</button>
            </div>
        </div>
    </div>
</div>

<div class="tracklistContainer borderBottom">
    <h2>Songs</h2>
    <ul class="tracklist">
        <?php
            $songIdArray = $artist->getSongIds();

            $i = 1;

            foreach($songIdArray as $songId){

                if($i > 5) {
                    break;
                }

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

<div class="gridViewContainer">
    <h2>Albums</h2>
    <?php 
        $albumQuery = mysqli_query($con, "SELECT * FROM album WHERE album_id IN (SELECT album_id FROM track WHERE track_id IN (SELECT track_id FROM track_artist WHERE artist_id='$artistId'))");
        while($row = mysqli_fetch_array($albumQuery)) {
            
            $artworkPath = $row['artwork_path'];
            $albumTitle = $row['title'];  
            $albumId = $row['album_id'];  
            
            echo "<div class='gridViewItem'>
                    <span role='link' tabindex='0' onclick='openPage(\"album.php?id=$albumId\")'>
                        <img src='$artworkPath'>

                        <div class='gridViewInfo'>
                            $albumTitle
                        </div>
                    </span>
                </div>";
        }
    ?>

</div>

<nav class="optionsMenu">
    <input type="hidden" class="songId">
    <?php echo Playlist::getPlaylistsDropdown($con, $userLoggedIn->getUserId()); ?>
</nav>
