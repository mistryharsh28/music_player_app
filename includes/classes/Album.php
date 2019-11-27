<?php 
    class Album{

        private $con;
        private $id;
        private $title;
        private $genre;
        private $artwork_path;
        private $created_by_artist;
        private $number_of_tracks;

        public function __construct($con, $id){
            $this->con = $con;
            $this->id = $id;
            $album_query = mysqli_query($this->con, "SELECT * FROM album WHERE album_id='$this->id'");
            $album = mysqli_fetch_array($album_query);

            $this->title = $album['title'];
            $this->genre = $album['genre'];
            $this->artwork_path = $album['artwork_path'];
            $this->number_of_tracks = $album['number_of_tracks'];
            $this->created_by_artist_id = $album['created_by_artist'];
        }

        public function getTitle(){
            return $this->title;
        }

        public function getArtworkPath(){
            return $this->artwork_path;
        }

        public function getCreatedByArtist(){
            return new Artist($this->con, $this->created_by_artist_id);
        }

        public function getGenre(){
            return $this->genre;
        }

        public function getNumberOfTracks(){
            return $this->number_of_tracks;
        }

        public function getSongIds(){
            $query = mysqli_query($this->con, "SELECT track_id, album_order FROM track WHERE album_id='$this->id' ORDER BY album_order ASC");
            $array = array();
            while($row = mysqli_fetch_array($query)){
                array_push($array, $row['track_id']);
            }

            return $array;
        }

        public function checkArtistRightsToAlbum($artist_id){
            if($artist_id == $this->created_by_artist_id){
                return true;
            }
            $query = mysqli_query($this->con, "SELECT * FROM track_artist WHERE artist_id=$artist_id AND track_id IN (SELECT track_id FROM track WHERE album_id=$this->id)");
            if(mysqli_num_rows($query) > 0){
                return true;
            }
            else{
                return false;
            }
        }
    }
?>