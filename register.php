<?php
// register.php

include_once 'dbconnect.php';
include 'header.php';

// action: register
if(isset($_POST['register']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "INSERT INTO user (username, password) VALUES ('$username','$password');";
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



// html: register
echo '
    <form action="" class="login_register" method="post">
        <!--<h1>Register</h1>-->
        <input type="text" id="username" name="username" value="" placeholder="Username" required><br>
        <input type="password" id="password" name="password" value="" placeholder="Password" required><br>
        <input type="submit" name="register" value="Register">
        <hr>
        <a href="/forum/login.php" class="button">Already have an account?</a>
    </form>';

include 'footer.php';
?>