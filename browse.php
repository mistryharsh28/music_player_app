<?php  
    include("includes/includedFiles.php");
?>
    <h1 class="pageHeadingBig">You Migth Also Like</h1>

    <div class="gridViewContainer">

        <?php 
            $albumQuery = mysqli_query($con, "SELECT * FROM album ORDER BY RAND() LIMIT 10");
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
