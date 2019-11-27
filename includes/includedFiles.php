<?php
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
        include("includes/config.php");
        include("includes/classes/User.php");
        include("includes/classes/Artist.php");
        include("includes/classes/Album.php");
        include("includes/classes/Track.php");
        include("includes/classes/Playlist.php");

        if(isset($_GET['userLoggedInId'])){
            $userLoggedIn = new User($con, $_GET['userLoggedInId']);
        }
        else{
            echo "User name variable not passed into the page.";

        }
    }
    else {
        include("includes/header.php");
        include("includes/footer.php");

        $url = $_SERVER['REQUEST_URI'];
        echo "<script>openPage('$url')</script>";
        exit();
    }
?>