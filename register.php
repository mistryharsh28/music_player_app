<!DOCTYPE html>

<?php
    include("includes/config.php");
    include("includes/classes/Account.php");
    include("includes/classes/Constants.php");

    $account = new Account($con);

    include("includes/handlers/register-handler.php");
    include("includes/handlers/login-handler.php");

    function getInputValue($name){
        if(isset($_POST[$name])){
            echo $_POST[$name];
        }
    }

?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="assets/css/register.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>
    <?php
        if(isset($_POST['registerButton'])){
            echo '<script>
                    $(document).ready(function() {
                        $("#loginForm").hide();
                        $("#registerForm").show();
                    });
                </script>';
        }
        else{
            echo '<script>
                    $(document).ready(function() {
                        $("#loginForm").show();
                        $("#registerForm").hide();
                    });
                </script>';
        }
    ?>
    

    <div id="background">

        <div id="loginContainer">

            <div id="inputContainer">
                <form action="register.php" id="loginForm" method="POST">
                    <h2>Login to your account</h2>
                    <p>
                        <?php echo $account->getError(Constants::$loginFailed); ?>
                        <label for="loginUsername">Username</label>
                        <input id="loginUsername" name="loginUsername" type="text" value="<?php getInputValue('loginUsername') ?>" placeholder="e.g. NarutoUzumaki" required>
                    </p>
                    <p>
                        <label for="loginPassword">Password</label>
                        <input id="loginPassword" name="loginPassword" type="password" required placeholder="Your Password"> 
                    </p>   
                    <button type="submit" name="loginButton">Login</button> 
                    <div class="hasAccountText">
                        <span id="hideLogin">Don't have an account yet? Signup here.</span>
                    </div>               
                </form>

                <form action="register.php" id="registerForm" method="POST">
                    <h2>Create your account</h2>
                    <p>
                        <?php echo $account->getError(Constants::$usernameCharacters); ?>
                        <?php echo $account->getError(Constants::$usernameTaken); ?>
                        <label for="username">Username</label>
                        <input id="username" name="username" type="text" value="<?php getInputValue('username') ?>" placeholder="e.g. NarutoUzumaki" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$nameCharacters); ?>
                        <label for="name">Name</label>
                        <input id="name" name="name" type="text" value="<?php getInputValue('name') ?>" placeholder="e.g. Harsh Mistry" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$emailInvalid); ?>
                        <?php echo $account->getError(Constants::$emailTaken); ?>
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" value="<?php getInputValue('email') ?>" placeholder="e.g. mistryharsh28@gmail.com" required>
                    </p>
                    <p>
                        <label for="address">Address</label>
                        <input id="address" name="address" type="text" value="<?php getInputValue('address') ?>" >
                    </p>
                    <p>
                        <label for="date_of_birth">Date Of Birth</label>
                        <input id="date_of_birth" name="date_of_birth" type="date" value="<?php getInputValue('date_of_birth') ?>" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$contactCharacters); ?>
                        <?php echo $account->getError(Constants::$contactNotNumeric); ?>
                        <label for="contact">Contact Number</label>
                        <input id="contact" name="contact" type="text" value="<?php getInputValue('contact') ?>" placeholder="e.g. 9969879437" required>
                    </p>
                    <p>
                        <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                        <?php echo $account->getError(Constants::$passwordNotAlphaNumeric); ?>
                        <?php echo $account->getError(Constants::$passwordCharacters); ?>
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" required placeholder="Your Password">
                    </p>   
                    <p>
                        <label for="password2">Confirm Password</label>
                        <input id="password2" name="password2" type="password" required placeholder="Your Password">
                    </p>   
                    <button type="submit" name="registerButton">Sign Up</button>                
                    <div class="hasAccountText">
                        <span id="hideRegister">Already have an account? Login here.</span>
                    </div>
                </form>
            </div>

            <div id="loginText">
                <h1>Get great music, right now</h1>
                <h2>Listen to loads of songs for free</h2>
                <ul>
                    <li>Discover music you will fall in love with.</li>
                    <li>Create your own playlists.</li>
                    <li>Follow artists to keep up to date.</li>
                </ul>
            </div>
        
        </div>
    
    </div>
</body>
</html>