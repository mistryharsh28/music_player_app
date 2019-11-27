<?php

    $trackQuery = mysqli_query($con, "SELECT track_id FROM track ORDER BY RAND() LIMIT 10 ");

    $resultArray = array();

    while($row = mysqli_fetch_array($trackQuery)){
        array_push($resultArray, $row['track_id']);
    }

    $jsonArray = json_encode($resultArray);

?>

<script>

    $(document).ready(function() {
        var newPlaylist = <?php echo $jsonArray; ?>;
        audioElement = new Audio();
        setTrack(newPlaylist[0], newPlaylist, false);
        updateVolumeProgressBar(audioElement.audio);

        $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e){
            e.preventDefault();
        });

        $(".playbackBar .progressBar").mousedown(function() {
            mouseDown = true;
        });

        $(".playbackBar .progressBar").mousemove(function(e) {
            if(mouseDown){
                // Set time of song
                timeFromOffset(e, this);
            }
        });

        $(".playbackBar .progressBar").mouseup(function(e) {
                timeFromOffset(e, this);
        });

        $(".volumeBar .progressBar").mousedown(function() {
            mouseDown = true;
        });

        $(".volumeBar .progressBar").mousemove(function(e) {
            if(mouseDown){
                
                var percentage = e.offsetX / $(this).width();

                if(percentage >= 0 && percentage <= 1){
                    audioElement.audio.volume = percentage;
                }
            }
        });

        $(".volumeBar .progressBar").mouseup(function(e) {
                var percentage = e.offsetX / $(this).width();
                if(percentage >= 0 && percentage <= 1){
                    audioElement.audio.volume = percentage;
                }
        });

        $(document).mouseup(function(){
            mouseDown = false;
        });

    });

    function timeFromOffset(mouse, progressBar){
        var percentage = mouse.offsetX / $(progressBar).width() * 100;
        var seconds = audioElement.audio.duration * (percentage / 100);
        audioElement.setTime(seconds);
    }

    function prevTrack(){
        if(audioElement.audio.currentTime >= 3 || currentIndex == 0){
            audioElement.setTime(0);
        }
        else{
            currentIndex = currentIndex - 1;
            var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
            setTrack(trackToPlay,currentPlaylist, true);
        }
    }

    function nextTrack(){
        if(repeat){
            audioElement.setTime(0);
            playTrack();
            return;
        }
        if(currentIndex == currentPlaylist.length - 1){
            currentIndex = 0;
        }
        else{
            currentIndex = currentIndex + 1;
        }
        var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
        setTrack(trackToPlay, currentPlaylist, true);
    }

    function setRepeat(){
        repeat = !repeat;
        var imageName = repeat ? "repeat-active.png" : "repeat.png";
        $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
    }

    function setMute(){
        audioElement.audio.muted = !audioElement.audio.muted;
        var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
        $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
    }

    function setShuffle(){
        shuffle = !shuffle;
        var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
        $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);

        if(shuffle){
            shuffleArray(shufflePlaylist);
            currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
        }
        else{
            currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
        }
    }

    function shuffleArray(a) {
        var j, x, i;
        for(i=a.length; i; i--){
            j = Math.floor(Math.random() * i);
            x = a[i - 1];
            a[i-1] = a[j];
            a[j] = x;
        }
    }

    function setTrack(trackId, newPlaylist, play){

        if(newPlaylist != currentPlaylist){
            currentPlaylist = newPlaylist;
            shufflePlaylist = currentPlaylist.slice();
            shuffleArray(shufflePlaylist);
        }

        if(shuffle == true) {
            currentIndex = shufflePlaylist.indexOf(trackId);
        }
        else{
            currentIndex = currentPlaylist.indexOf(trackId);
        }
        pauseTrack(); 

        $.post("includes/handlers/ajax/getTrackJson.php", { trackId:trackId }, function(data) {
            var track = JSON.parse(data);

            $(".trackName span").text(track.title);

            $.post("includes/handlers/ajax/getArtistsJson.php", { trackId:trackId }, function(data) {
                var artists = JSON.parse(data);
                $(".trackInfo .artistName span").text(artists);
            });

            $.post("includes/handlers/ajax/getAlbumJson.php", { albumId:track.album_id }, function(data) {
                var album = JSON.parse(data);
                $(".content .albumLink img").attr("src", album.artwork_path);
                $(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + track.album_id + "')");
                $(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + track.album_id + "')");
            });

            audioElement.setTrack(track);

            if(play == true) {
                playTrack();
            }

        });
    }

    function playTrack(){

        if(audioElement.audio.currentTime == 0){
            $.post("includes/handlers/ajax/updatePlays.php", { trackId:audioElement.currentlyPlaying.track_id });
        }

        audioElement.play();
        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
    }

    function pauseTrack(){
        audioElement.pause();
        $(".controlButton.play").show();
        $(".controlButton.pause").hide();
    }

</script>


<div id="nowPlayingBarContainer">

    <div id="nowPlayingBar">

        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img role="link" tabindex="0" src="" class="albumArtwork" alt="">
                </span>
                <div class="trackInfo">
                    <span class="trackName">
                        <span role="link" tabindex="0"></span>
                    </span>
                    <span class="artistName">
                        <span>Harsh Mistry</span>
                    </span>
                </div>
            </div>
        </div>

        <div id="nowPlayingCenter">

            <div class="content playerControls">
                <div class="buttons">

                    <button class="controlButton shuffle" title="Shuffle" onclick="setShuffle()">
                        <img src="assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>

                    <button class="controlButton previous" title="Previous" onclick="prevTrack()">
                        <img src="assets/images/icons/previous.png" alt="Previous">
                    </button>

                    <button class="controlButton play" title="Play" onclick="playTrack()">
                        <img src="assets/images/icons/play.png" alt="Play">
                    </button>

                    <button class="controlButton pause" title="Pause" style="display:none;" onclick="pauseTrack()">
                        <img src="assets/images/icons/pause.png" alt="Pause">
                    </button>

                    <button class="controlButton next" title="Next" onclick="nextTrack()">
                        <img src="assets/images/icons/next.png" alt="Next">
                    </button>

                    <button class="controlButton repeat" title="Repeat" onclick="setRepeat()">
                        <img src="assets/images/icons/repeat.png" alt="Repeat">
                    </button>

                </div>

                <div class="playbackBar">
                    <span class="progressTime current">0.00</span>
                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>
                    <span class="progressTime remaining">0.00</span>
                </div>
            </div>

        </div>

        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="Volume" onclick="setMute()">
                    <img src="assets/images/icons/volume.png" alt="Volume">
                </button>
                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>