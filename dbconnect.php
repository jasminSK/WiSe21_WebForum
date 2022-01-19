<?php
// dbconnect.php

$servername='localhost';
$username='root'; // you should create a seperate account with minimal permissions
$password=''; // this is only empty for easier installation
$dbname = "forumsec";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if(!$conn){
  die('Could not connect to database.');
}

?>