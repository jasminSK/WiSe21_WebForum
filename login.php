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
    $sql = "SELECT * FROM `user` WHERE `username`= '$username' AND `password` = '$password'";
    if ($res = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($res) > 0) {
            echo "login success";
            if ($row = mysqli_fetch_array($res)) {
                echo "<br><hr><br>";
                echo "username: " . $row['username'] . "<br>";

                // Session-Cookie
                $_SESSION['signed_in'] = true; //write signed_in to server storage
                $_SESSION['username'] = $row['username']; 
                $_SESSION['file_path'] = $row['file_path'];
                $_SESSION['is_admin'] = $row['is_admin'];
                $_SESSION['user_id'] = $row['user_id'];

                
                
                header('Location: /forumsec/index.php'); //redirect to main

            }
            mysqli_free_res($res);
        }
        else {
            echo '
                <div class="alert red">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                    <b>Error:</b> No matching records are found.
                </div>
            ';
        }
    }
    else {
        echo "ERROR: Could not execute<br>$sql. " .mysqli_error($link);
    }
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