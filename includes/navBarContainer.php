<div id="navBarContainer">
    <nav class="navBar">

        <span role="link" tabindex="0" onclick="openPage('index.php')" class="logo">
            <img src="assets/images/icons/logo.png" alt="">
        </span>

        <div class="group">

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('search.php')" class="navItemLink">Search
                    <img src="assets/images/icons/search.png" class="icon" alt="Search">
                </span>
            </div>

        </div>
        
        <div class="group">

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('browse.php')" class="navItemLink">Browse</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('your_music.php')" class="navItemLink">Your Music</span>
            </div>

            <div class="navItem">
                <span role="link" tabindex="0" onclick="openPage('settings.php')" class="navItemLink"><?php echo $userLoggedIn->getName(); ?></span>
            </div>

            <div class="navItem">
                <?php
                    if($userLoggedIn->isArtist()){
                        echo "<span role='link' tabindex='0' onclick='openPage(\"add_music.php?\")' class='navItemLink'>Add Music</span>"; 
                    } 
                ?>
            </div>

        </div>

    </nav>
</div>