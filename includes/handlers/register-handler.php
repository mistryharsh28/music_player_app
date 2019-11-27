<?php

    function sanitizeFormText($inputText) {
        $inputText = strip_tags($inputText);
        $inputText = str_replace(" ", "", $inputText);
        return $inputText;
    }
    
    if(isset($_POST['registerButton'])){
        //Register button pressed
        $username = sanitizeFormText($_POST['username']);
        $name = strip_tags($_POST['name']);
        $email = sanitizeFormText($_POST['email']);
        $address = strip_tags($_POST['address']);
        $contact = sanitizeFormText($_POST['contact']);
        $date_of_birth = sanitizeFormText($_POST['date_of_birth']);
        $password = sanitizeFormText($_POST['password']);
        $password2 = sanitizeFormText($_POST['password2']);

        $wasSuccessful = $account->register($username, $name, $email, $contact, $password, $password2, $address, $date_of_birth);
        if($wasSuccessful){

            $query = mysqli_query($con, "SELECT id FROM user WHERE username='$username'");
            $user_id = mysqli_fetch_array($query);
            $user_id = $user_id['id'];

            $_SESSION['userLoggedIn'] = $username;
            $_SESSION['userLoggedInId'] = $user_id;
            header("Location: index.php");  
        }
    }

?>