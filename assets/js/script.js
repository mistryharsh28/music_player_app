var currentPlaylist = Array();
var shufflePlaylist = Array();
var tempPlaylist = Array();
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false;
var userLoggedIn;
var userLoggedInId;
var timer;

$(document).click(function(click) {
    var target = $(click.target);
    if(!target.hasClass("item") && !target.hasClass('optionButton')){
        hideOptionsMenu();
    }
});

$(document).on("change", "select.playlist", function() {
    var select = $(this);
    var playlistId = select.val();
    var songId = select.prev(".songId").val();

    $.post("includes/handlers/ajax/addToPlaylist.php", {playlistId: playlistId, songId:songId})
    .done(function (error) {

        if(error != ""){
            alert(error);
            return;
        }

        hideOptionsMenu();
        select.val("");
    });

});

$(window).scroll(function() {
    hideOptionsMenu();
});

function openPage(url){

    if(timer != null) {
        clearTimeout(timer);
    }

    if(url.indexOf("?") == -1){
        url = url + "?";
    }

    var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn + "&userLoggedInId=" + userLoggedInId);
    console.info(encodedUrl);
    $("#mainContent").load(encodedUrl);

    $("body").scrollTop(0);
    history.pushState(null, null, url);
}

function hideOptionsMenu(){
    var menu = $(".optionsMenu");
    if(menu.css("display") != "none"){
        menu.css("display","none");
    }
}

function showOptionsMenu(button){

    var songId = $(button).prevAll(".songId").val();

    var menu = $(".optionsMenu");
    var menuWidth = menu.width();
    var scrollTop = $(window).scrollTop();
    var elementOffset = $(button).offset().top;

    menu.find(".songId").val(songId);
    var top = elementOffset - scrollTop;
    var left = $(button).position().left;

    menu.css({"top": top + "px", "left": left - menuWidth + "px", "display": "inline" });

}

function removeFromPlaylist(button, playlistId) {
    var songId = $(button).prevAll(".songId").val();
    $.post("includes/handlers/ajax/removeFromPlaylist.php", {playlistId:playlistId, songId:songId})
    .done(function(error){
        // do something when ajax return

        if(error != ""){
            alert(error);
            return;
        }

        openPage("playlist.php?id=" + playlistId);
    });
}

function createPlaylist() {
    var popup = prompt("Please enter the name of the playlist");

    if(popup != null){
        $.post("includes/handlers/ajax/createPlaylist.php", {title: popup, username: userLoggedIn, userid: userLoggedInId})
        .done(function(error){
            // do something when ajax return

            if(error != ""){
                alert(error);
                return;
            }

            openPage("your_music.php");
        });
    }
}

function createAlbum() {
    var popup = prompt("Please enter the name of the album");

    if(popup != null){
        $.post("includes/handlers/ajax/createAlbum.php", {title: popup, username: userLoggedIn, userid: userLoggedInId})
        .done(function(error){
            // do something when ajax return

            if(error != ""){
                alert(error);
                return;
            }

            openPage("add_music.php");
        });
    }
}

function deletePlaylist(playlistId) {
    var prompt = confirm("Are you sure you want to delete this playlist?");
    if(prompt){
        $.post("includes/handlers/ajax/deletePlaylist.php", {playlistId:playlistId})
        .done(function(error){
            // do something when ajax return

            if(error != ""){
                alert(error);
                return;
            }

            openPage("your_music.php");
        });
    }
}

function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60);
    var seconds = time - (minutes * 60);

    var extraZero;

    if(seconds < 10) {
        extraZero = "0";
    }
    else {
        extraZero = "";
    }

    return minutes + ":" + extraZero +seconds;
}

function updateTimeProgressBar(audio){
    $(".progressTime.current").text(formatTime(audio.currentTime));
    $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));

    var progress = (audio.currentTime / audio.duration) * 100;
    $(".playbackBar .progress").css("width", progress + "%");
}

function updateVolumeProgressBar(audio){
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");
}

function playFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}

function Audio(){

    this.currentlyPlaying;
    this.audio = document.createElement('audio');

    this.audio.addEventListener("canplay", function() {
        $(".progressTime.remaining").text(formatTime(this.duration)); // here this refers to the object the event is called on
    });

    this.audio.addEventListener("timeupdate", function() {
        if(this.duration) {
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function() {
        updateVolumeProgressBar(this);
    });

    this.audio.addEventListener("ended", function() {
        nextTrack();
    });

    this.setTrack = function(track) {
        this.audio.src = track.path;
        this.currentlyPlaying = track;
    }

    this.play = function(){
        this.audio.play();
    }

    this.pause = function(){
        this.audio.pause();
    }

    this.setTime = function(seconds){
        this.audio.currentTime = seconds;
    }
}


function logout(){
    $.post("includes/handlers/ajax/logout.php", function() {
        location.reload();
    });
}

function updateEmail(emailClass){
    var emailValue = $("." + emailClass).val();

    $.post("includes/handlers/ajax/updateEmail.php", {email: emailValue, username:userLoggedIn})
    .done(function(response) {
        $("." + emailClass).nextAll(".message").text(response);
    });
}


function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2){
    var oldPassword = $("." + oldPasswordClass).val();
    var newPassword1 = $("." + newPasswordClass1).val();
    var newPassword2 = $("." + newPasswordClass2).val();

    $.post("includes/handlers/ajax/updatePassword.php", 
        {oldPassword: oldPassword, newPassword1: newPassword1, newPassword2: newPassword2, username:userLoggedIn})
    .done(function(response) {
        $("." + oldPasswordClass).nextAll(".message").text(response);
    });
}

function addTrack(titleClass, genreClass, trackClass, albumId){
    // try {
        var formData = new FormData();
        var title = $("." + titleClass).val();
        var genre = $("." + genreClass).val();
        var track = $("." + trackClass)[0].files[0];
        var uploadedAudio = document.createElement('audio');
        
        uploadedAudio.addEventListener('canplay', function() {
            var duration = formatTime(uploadedAudio.duration);

            formData.set('title', title);
            formData.set('genre', genre);
            formData.set('duration', duration);
            formData.set('track', track);
            formData.set('username', userLoggedIn);
            formData.set('albumId', albumId);
            $.ajax({
                url: 'includes/handlers/ajax/addTrack.php',
                type: 'POST',
                data: formData,
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    $("." + trackClass).nextAll(".message").text(response);
                },
                error: function (response) {
                    $("." + trackClass).nextAll(".message").text(response);
                }
            });
        });
    
    uploadedAudio.src = URL.createObjectURL(track);
}