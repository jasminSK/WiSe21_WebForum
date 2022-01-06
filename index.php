<?php
// index.php

include_once 'dbconnect.php';
include 'header.php';
echo '<h1>This is the startpage!</h1>';
echo '<br><br><br>';



//if sid exists and login for sid exists
session_start(); //gets session id 
if (session_id() == '' || !isset($_SESSION['signed_in'])) {
    echo'You are currently not logged in login <a href="./login.php">here</a>.';
} else {
    echo "<h4>Account:</h4>";
    echo "username: " . $_SESSION['username'] . "<br>";
    echo "user_id: " . $_SESSION['user_id'] . "<br>";
    echo "logged_in: " . $_SESSION['signed_in'] . "<br>";
    echo "admin: " . $_SESSION['is_admin'] . "<br>";
    echo "<hr>";

    
    echo '
    <form action="" method="post">
        <input type="text" id="username" name="username" value="" placeholder="Title" required><br>
        <input type="password" id="password" name="password" value="" placeholder="Text" required><br>
        <input type="submit" name="login" value="Sumbit">
    </form>
    ';





    $sql = "SELECT * FROM post ORDER BY post_id DESC";

    if ($res = mysqli_query($conn, $sql)) {
        echo '<table border="1">';
        echo "<tr>";
            echo "<td>post_id</td>";
            echo "<td>title</td>";
            echo "<td>content</td>";
            echo "<td>author</td>";
            echo "<td>creation_date</td>";
        echo "</tr>";

        while ($row = mysqli_fetch_array( $res, MYSQLI_ASSOC))
        {
            echo "<tr>";
                echo "<td>". $row['post_id'] . "</td>";
                echo "<td>". $row['title'] . "</td>";
                echo "<td>". $row['content'] . "</td>";
                echo "<td>". $row['author'] . "</td>";
                echo "<td>". $row['creation_date'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        mysqli_free_result($res);

    }else {
        echo "ERROR: Could not able to execute<br>";
    }
    mysqli_close($conn);
    
    



  
    
}

include 'footer.php';
?>