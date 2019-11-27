<?php 
    class Track{

        private $con;
        private $id;
        private $mysqliData;
        private $title;
        private $album_id;
        private $genre;
        private $duration;
        private $path;

        public function __construct($con, $id){
            $this->con = $con;
            $this->id = $id;

            $query = mysqli_query($this->con, "SELECT * FROM track WHERE track_id='$this->id'");
            $this->mysqliData = mysqli_fetch_array($query);
            $this->title = $this->mysqliData['title'];
            $this->album_id = $this->mysqliData['album_id'];
            $this->genre = $this->mysqliData['genre'];
            $this->duration = $this->mysqliData['duration'];
            $this->path = $this->mysqliData['path'];
        }

        public function getTitle(){
            return $this->title;
        }

        public function getPath(){
            return $this->path;
        }

        public function getGenre(){
            return $this->genre;
        }

        public function getDuration(){
            return $this->duration;
        }

        public function getArtists(){
            $artists = "";

            $query = mysqli_query($this->con, "SELECT artist_id FROM track_artist WHERE track_id='$this->id'");
            while($row = mysqli_fetch_array($query)){
                $artist = new Artist($this->con, $row['artist_id']);
                $artists = $artists . $artist->getName() . " & ";
            }

            $artists = substr($artists, 0, -3);

            return $artists;
        }

        public function getAlbum(){
            return new Album($this->con, $this->album_id);
        }

        public function getMysqliData(){
            return $this->mysqliData;
        }

        public function getId(){
            return $this->id;
        }

    }   
?>