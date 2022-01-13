<?php
// index.php

session_start(); //gets session id 
include_once 'dbconnect.php';
include 'header.php';


// action: login
include_once 'dbconnect.php';
if(isset($_POST['login']))
{  
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `user` WHERE `username`= '$username'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
    $hash = $row['password'];

    // check if password is correct
    if(password_verify($password, $hash)){
        // Session-Cookie
        $_SESSION['signed_in'] = true;
        $_SESSION['username'] = $row['username']; 
        $_SESSION['is_admin'] = $row['is_admin'];
        $_SESSION['user_id'] = $row['user_id'];
        
        header('Location: /forumsec/index.php'); //redirect to main
    
    }else{
        echo '
                <div class="alert red">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                    <b>Error:</b> No matching records are found.
                </div>
            ';
    }
    mysqli_free_res($res);
    mysqli_close($conn);
}



// html: login
echo '
    <form class="login_register" action="" method="post">
        <input type="text" id="username" name="username" value="" placeholder="Username" required><br>
        <input type="password" id="password" name="password" value="" placeholder="Password" required><br>
        <input type="submit" name="login" value="Log In">
        <hr>
        <a href="/forumsec/register.php" class="button">Don\'t have an account yet?</a>
    </form>';

include 'footer.php'
?>