<?php
include_once 'dbconnect.php';

// LOGIN
if(isset($_POST['login']))
{  
    echo '
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Account</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <form action="check.php" method="post">
    <h1>Account settings:</h1><br>
    ';

    $username = $_POST['username'];
    $password = $_POST['password'];
   
    $sql = "SELECT * FROM `user` WHERE `username`= '$username' AND `password` = '$password'";
    if ($res = mysqli_query($conn, $sql)) {
        if (mysqli_num_rows($res) > 0) {
            echo "login success";
            while ($row = mysqli_fetch_array($res)) {
                echo "<br><hr><br>";
                echo "username: " . $row['username'] . "<br>";
                echo "password: " . $row['password'] . "<br>";
                echo "creation: " . $row['creation_date'] . "<br>";
                echo "is admin: " . $row['is_admin'] . "<br>";
            }
            mysqli_free_res($res);
        }
        else {
            echo "No matching records are found.";
        }
    }
    else {
        echo "ERROR: Could not able to execute<br>$sql. " .mysqli_error($link);
    }
    mysqli_close($conn);

    echo '
            </form>
        </body>
        </html>
    ';
}


// REGISTER
if(isset($_POST['register']))
{
    echo '
        <!doctype html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>Secret Message</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="style.css">
        </head>
        <script type="text/javascript">
            var myVar=setInterval(function () {redirect()}, 2000);
            function redirect() {
            window.location="./"
        }
       </script>
        <body>
        <form action="check.php" method="post">   
    ';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "INSERT INTO user (username, password)
    VALUES ('$username','$password');";
    if (mysqli_query($conn, $sql)) {
        echo "<h2>Account was created!</h2><br>SQL:<br>" . $sql . "<br>" . mysqli_error($conn);
    } else {
        echo "SQL:<br>".$sql . "<br><br>Error:<br>" .mysqli_error($conn);
    }
    mysqli_close($conn);

    echo '
            </form>
        </body>
        </html>
    ';
}

?>