<?php 
    class Artist{

        private $con;
        private $id;

        public function __construct($con, $id){
            $this->con = $con;
            $this->id = $id;
        }

        public function getId(){
            return $this->id;
        }

        public function getName(){
            $artist_query = mysqli_query($this->con, "SELECT * FROM user WHERE id='$this->id' AND is_artist=1");
            $artist = mysqli_fetch_array($artist_query);
            return $artist['name'];
        }

        public function getSongIds(){
            $query = mysqli_query($this->con, "SELECT track_id FROM track WHERE track_id IN (SELECT track_id FROM track_artist WHERE artist_id='$this->id') ORDER BY plays DESC");
            $array = array();
            while($row = mysqli_fetch_array($query)){
                array_push($array, $row['track_id']);
            }

            return $array;
        }

    }
?>