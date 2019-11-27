<?php
    class User {

        private $userid;
        private $con;
        private $name;
        private $username;
        private $email;
        private $isArtist;


        public function __construct($con, $userid) {
            $this->userid = $userid;
            $this->con = $con;

            $query = mysqli_query($this->con, "SELECT * FROM user WHERE id='$this->userid'");
            $user = mysqli_fetch_array($query);
            $this->name = $user['name'];
            $this->username = $user['username'];
            $this->email = $user['email'];
            $this->isArtist = $user['is_artist'];
        }

        public function getUsername() {
            return $this->username;
        }

        public function getName() {
            return $this->name;
        }

        public function getUserId() {
            return $this->userid;
        }
        
        public function getEmail() {
            return $this->email;
        }

        public function isArtist() {
            return $this->isArtist;
        }

    }
?>