<?php
// register.php

include_once 'dbconnect.php';
include 'header.php';

// action: register
if(isset($_POST['register']))
{
    $password = $_POST['password'];
    
    // check password strength
    if(strlen($password) < 9){$regexError .= "- Password too short!<br>";}
    if(strlen($password) > 32){$regexError .= "- Password too long!<br>";}
    if(!preg_match("#[0-9]+#", $password)){$regexError .= "- Password must include at least one number!<br>";}
    if(!preg_match("#[a-z]+#", $password)){$regexError .= "- Password must include at least one letter!<br>";}
    if(!preg_match("#[A-Z]+#", $password)){$regexError .= "- Password must include at least one capital letter!<br>";}
    if(!preg_match("#\W+#"   , $password)){$regexError .= "- Password must include at least one symbol!<br>";}
    
    if($regexError){
        echo '<div class="alert red">
                <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
        echo "<b>Error:</b><br>$regexError
            </div>";

    }else{

        $username = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['username']));
        $passwordHash = password_hash(htmlspecialchars(mysqli_real_escape_string($conn, $password)), PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO `user` (`username`, `password`) VALUES ('$username','$passwordHash');";
        if (mysqli_query($conn, $sql)) {
            echo '
                    <div class="alert green">
                        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                        <b>Success:</b> Account was created!
                    </div>
                ';
        } else {
            echo '
                    <div class="alert red">
                        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                        <b>Error:</b> Username is already taken!
                    </div>
                ';
        }
        mysqli_close($conn);

    }
}



// html: register
echo '
    <form action="" class="login_register" method="post">
        <!--<h1>Register</h1>-->
        <input type="text" id="username" name="username" value="" placeholder="Username" required><br>
        <input type="password" id="password" name="password" value="" placeholder="Password" required><br>
        <input type="submit" name="register" value="Register">
        <hr>
        <a href="/forumsec/login.php" class="button">Already have an account?</a>
    </form>';

include 'footer.php';
?>