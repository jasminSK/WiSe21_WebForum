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
        echo "<h2>Account was created!</h2><br>";
    } else {
        echo "SQL:<br>".$sql . "<br><br>Error:<br>" .mysqli_error($conn);
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
        <a href="./login.php" class="button">Already have an account?</a>
    </form>';

include 'footer.php';
?>