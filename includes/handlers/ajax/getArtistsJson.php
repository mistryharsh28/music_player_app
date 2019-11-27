<?php
    
    include("../../config.php");
    include("../../classes/Artist.php");
    include("../../classes/Album.php");
    include("../../classes/Track.php");

    if(isset($_POST['trackId'])){
        $trackId = $_POST['trackId'];

        $track = new Track($con, $trackId);

        echo json_encode($track->getArtists());
    }

?>