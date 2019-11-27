<?php

    include("includes/includedFiles.php");


    if(isset($_GET['term'])){
        $term = urldecode($_GET['term']);
    }
    else{
        $term = "";
    }

?>

<div class="searchContainer">

    <h4>Search for an Artist, Album or Song</h4>
    <input type="text" class="searchInput" value="<?php echo $term; ?>" placeholder="Start typing...." onfocus="this.selectionStart = this.selectionEnd = this.value.length;" >

</div>

<script>

    $(".searchInput").focus();

    $(function() {
        

        $(".searchInput").keyup(function() {
            clearTimeout(timer);
            timer = setTimeout(function() {
                var val = $(".searchInput").val();
                openPage("search.php?term=" + val);
            }, 500);
        })


    })

</script>

<?php 
    if($term == "") exit();
?>


<div class="tracklistContainer borderBottom">
    <h2>Songs</h2>
    <ul class="tracklist">
        <?php

            $query = mysqli_query($con, "SELECT track_id FROM track WHERE title LIKE '$term%' LIMIT 10");
            if(mysqli_num_rows($query) == 0){
                echo "<span class='noResults'>No songs found matching " . $term . "</span>";
            }

            $songIdArray = array();

            $i = 1;

            while($row=mysqli_fetch_array($query)){

                if($i > 10) {
                    break;
                }

                array_push($songIdArray, $row['track_id']);

                $albumTrack = new Track($con, $row['track_id']);
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


<div class="artistContainer borderBottom">
    <h2>ARTISTS</h2>

    <?php

        $artist_query = mysqli_query($con, "SELECT id FROM user WHERE name LIKE '$term%' AND is_artist=1 LIMIT 10");

        if(mysqli_num_rows($artist_query) == 0){
            echo "<span class='noResults'>No Artists found matching " . $term . "</span>";
        }

        while($row=mysqli_fetch_array($artist_query)){
            $artistFound = new Artist($con, $row['id']);

            echo "
                <div class='searchResultRow'>
                    <div class='artistName'>
                    
                        <span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getId() . "\")'>

                            " . $artistFound->getName() . "

                        </span>
                    
                    </div>
                
                </div>
            ";

        }

    ?>
</div>

<div class="gridViewContainer">
    <h2>ALBUMS</h2>
    <?php 
        $albumQuery = mysqli_query($con, "SELECT * FROM album WHERE title LIKE '$term%' LIMIT 10");

        if(mysqli_num_rows($albumQuery) == 0){
            echo "<span class='noResults'>No Albums found matching " . $term . "</span>";
        }

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
