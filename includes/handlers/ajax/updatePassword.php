<?php

    include("../../config.php");

    if(!isset($_POST['username'])){
        echo 'Error';
    }

    if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])){
        echo "Not all password is set";
        exit();
    }

    if($_POST['oldPassword'] == "" || $_POST['newPassword1'] == "" || $_POST['newPassword2'] == ""){
        echo "Please fill all fields";
        exit();
    }

    $username = $_POST['username'];
    $oldPassword = $_POST['oldPassword'];
    $newPassword1 = $_POST['newPassword1'];
    $newPassword2 = $_POST['newPassword2'];

    $oldMd5 = md5($oldPassword);

    $query = mysqli_query($con, "SELECT * FROM user WHERE username='$username' AND password='$oldMd5'");
    if(mysqli_num_rows($query) != 1){
        echo "Password is incorrect";
        exit();
    }

    if($newPassword1 != $newPassword2){
        echo "Passwords does not match";
        exit();
    }

    if(!preg_match('/[A-Za-z0-9]/', $newPassword1)){
        echo "Password must contain only letters and numbers";
        exit();
    }

    if(strlen($newPassword1) > 30 || strlen($newPassword1) < 5){
        echo "Your username must be between 5 and 30 characters";
        exit();
    }

    $newMd5 = md5($newPassword1);

    $query = mysqli_query($con, "UPDATE user SET password='$newMd5' WHERE username='$username'");
    echo "Update Successful";


?>