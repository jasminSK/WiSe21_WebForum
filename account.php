<?php
// index.php

include_once 'dbconnect.php';
include 'header.php';

// if sid exists and login for sid exists
session_start(); // gets session id 
if (session_id() == '' || !isset($_SESSION['signed_in'])) { // if not logged in 
    echo'<br>You are currently not logged in login <a href="./login.php">here</a>.';
} else { // if logged in 
    echo "<h4>Account:</h4>";
    echo "username: " . $_SESSION['username'] . "<br>";
    echo "user_id: " . $_SESSION['user_id'] . "<br>";
    echo "logged_in: " . $_SESSION['signed_in'] . "<br>";
    echo "admin: " . $_SESSION['is_admin'] . "<br>";
    echo "<hr>";
}

include 'footer.php';
?>