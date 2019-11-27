<?php

    if(isset($_POST['loginButton'])){
        //Login button pressed
        $username = sanitizeFormText($_POST['loginUsername']);
        $password = sanitizeFormText($_POST['loginPassword']);

        //Login function
        $result = $account->login($username, $password);
        if($result){

            $query = mysqli_query($con, "SELECT id FROM user WHERE username='$username'");
            $user_id = mysqli_fetch_array($query);
            $user_id = $user_id['id'];

            $_SESSION['userLoggedIn'] = $username;
            $_SESSION['userLoggedInId'] = $user_id;
            header("Location: index.php");
        }
    }

?>
