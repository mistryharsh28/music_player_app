<?php
    class Account {

        private $errorArray;
        private $con;

        public function __construct($con) {
            $this->errorArray = array();
            $this->con = $con;
        }

        public function login($un, $pw){
            $encryptedPw = md5($pw);

            $query = mysqli_query($this->con, "SELECT * FROM user WHERE username='$un' AND password='$encryptedPw'");
            if(mysqli_num_rows($query) == 1){
                return true;
            }
            else{
                array_push($this->errorArray, Constants::$loginFailed);
                return false;
            }
        }

        public function register($un, $nm, $em, $ct, $p1, $p2, $ad, $dob){
            $this->validateUsername($un);
            $this->validateName($nm);
            $this->validateEmail($em);
            $this->validateContact($ct);
            $this->validatePasswords($p1, $p2);

            if(empty($this->errorArray)){
                //Insert in database
                return $this->insertuserDetails($un, $nm, $em, $p1, $ad, $dob, $ct);
            }
            else{
                return false;
            }
        }

        public function getError($error){
            if(!in_array($error, $this->errorArray)){
                $error = "";
            }
            return "<span class='errorMessage'>$error</span>";
        }

        private function insertuserDetails($un, $nm, $em, $p1, $ad, $dob, $ct){
            $encryptedPw = md5($p1);
            $profilePic = "assets/images/profile_pic/itachi_Uchiha.jpg";
            $date = date("Y-m-d");
            $dob = date($dob);

            $result = mysqli_query($this->con, "INSERT INTO user (id, username, name, email, password, address, date_of_birth, contact, photo, sign_up_date) VALUES ('', '$un', '$nm', '$em', '$encryptedPw', '$ad', '$dob', '$ct', '$profilePic', '$date')");
            
            echo $result;
            return $result;
        }

        private function validateUsername($un){
            if(strlen($un) > 25 || strlen($un) < 5){
                array_push($this->errorArray, Constants::$usernameCharacters);
                return;
            }

            // Check if username already exists
            $checkUsernameQuery = mysqli_query($this->con, "SELECT username FROM user WHERE username='$un'");
            if(mysqli_num_rows($checkUsernameQuery) != 0){
                array_push($this->errorArray, Constants::$usernameTaken);
                return;
            }
        }
    
        private function validateName($nm){
            if(strlen($nm) > 25 || strlen($nm) < 2){
                array_push($this->errorArray, Constants::$nameCharacters);
                return;
            }
        }
    
        private function validateEmail($em){
            if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
                array_push($this->errorArray, Constants::$emailInvalid);
                return;
            }

            // Check email is already used or not
            $checkEmailQuery = mysqli_query($this->con, "SELECT email FROM user WHERE email='$em'");
            if(mysqli_num_rows($checkEmailQuery) != 0){
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }
        }
    
        private function validateContact($ct) {
            if(strlen($ct) > 15 || strlen($ct) < 10){
                array_push($this->errorArray, Constants::$contactCharacters);
                return;
            }

            if(!ctype_digit($ct)){
                array_push($this->errorArray, Constants::$contactNotNumeric);
                return;
            }
        }
        
        private function validatePasswords($p1, $p2){
            if($p1 != $p2){
                array_push($this->errorArray, Constants::$passwordsDoNotMatch);
                return;
            }

            if(preg_match('/[^A-Za-z0-9]/', $p1)){
                array_push($this->errorArray, Constants::$passwordNotAlphaNumeric);
                return;
            }

            if(strlen($p1) > 30 || strlen($p1) < 5){
                array_push($this->errorArray, Constants::$passwordCharacters);
                return;
            }
        }

    }
?>