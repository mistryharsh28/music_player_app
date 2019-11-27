<?php
    class Playlist {

        private $id;
        private $con;
        private $title;
        private $user_id;
        private $number_of_tracks;

        public function __construct($con, $id) {
            $this->id = $id;
            $this->con = $con;

            $query = mysqli_query($this->con, "SELECT * FROM playlist WHERE playlist_id='$this->id'");
            $playlist = mysqli_fetch_array($query);
            $this->title = $playlist['title'];
            $this->user_id = $playlist['user_id'];
            $this->number_of_tracks = $playlist['number_of_tracks'];
        }

        public function getTitle() {
            return $this->title;
        }

        public function getNumberOfTracks() {
            return $this->number_of_tracks;
        }

        public function getUserId() {
            return $this->user_id;
        }

        public function getId() {
            return $this->id;
        }

        public function getSongIds(){
            $query = mysqli_query($this->con, "SELECT track_id, playlist_order FROM playlist_track WHERE playlist_id='$this->id' ORDER BY playlist_order ASC");
            $array = array();
            while($row = mysqli_fetch_array($query)){
                array_push($array, $row['track_id']);
            }

            return $array;
        }

        public static function getPlaylistsDropdown($con, $user_id){
            $dropdown = '<select class="item playlist" >
                            <option value="">Add to playlist</option>';

            $query = mysqli_query($con, "SELECT playlist_id, title FROM playlist WHERE user_id=$user_id");
            while($row = mysqli_fetch_array($query)){
                $id = $row['playlist_id'];
                $title = $row['title'];
                $dropdown = $dropdown . "<option value='$id'>$title</option>";
            }

            return $dropdown . '</select>';
        }
    }
?>