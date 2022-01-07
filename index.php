<?php
// index.php

include_once 'dbconnect.php';
include 'header.php';

//if sid exists and login for sid exists
session_start(); //gets session id 
if (session_id() == '' || !isset($_SESSION['signed_in'])) {
    echo'You are currently not logged in login <a href="./login.php">here</a>.';
} else {
    echo "<div class=window>";
    echo "<h4>Account:</h4>";
    echo "username: " . $_SESSION['username'] . "<br>";
    echo "user_id: " . $_SESSION['user_id'] . "<br>";
    echo "logged_in: " . $_SESSION['signed_in'] . "<br>";
    echo "admin: " . $_SESSION['is_admin'] . "<br>";
    echo "<hr>";
    echo "</div>";
    
    // action: create post
    if(isset($_POST['createpost']))
    {
        $title = $_POST['title'];
        $text = $_POST['text'];
        $author = $_SESSION['user_id'];
        $sql = "INSERT INTO post (title, content, author) VALUES ('$title','$text', '$author');";
        if (mysqli_query($conn, $sql)) {
            echo "Post has been sent<br>";
        } else {
            echo "SQL:<br>".$sql . "<br><br>Error:<br>" .mysqli_error($conn);
        }
    }

    //Selects all posts
    $sql = "SELECT * FROM post ORDER BY post_id DESC";
    //Displays all posts and puts it into a window
    if ($res = mysqli_query($conn, $sql)) {
        echo "<div class='window scroll forum'>";
        //Goes trough all rows and creates the post bubbles
        while ($row = mysqli_fetch_array( $res, MYSQLI_ASSOC))
        {   
            $title= $row['title'];
            $content = $row['content'];
            $creation_date = $row['creation_date'];
            $author_id = $row['author'];
            $sql = "SELECT username FROM user WHERE user.user_id=$author_id;";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array( $result, MYSQLI_ASSOC);
            $username = $row['username'];
            
            echo "<div class='post'>";
                echo "<h4>$title</h4>";
                echo "<div>$content</div>";
                echo "<div class='left'>By $username</div>";
                echo "<div class='right'>$creation_date</div>";
            echo "</div>";
            echo "<br>";
        }
        echo "</div>";
        mysqli_free_result($res);

    }else {
        echo "ERROR: Could not able to execute<br>";
    }
    
    //HTML - form for writing and sending post
    echo'
    <div class="window">
    <form action="" method="post" id="submitpost">
        <input type="text" id="title" name="title" value="" placeholder="Title" required><br>
        <input type="text" id="text" name="text" value="" placeholder="Text" required><br>
        <input type="submit" id="createpost" class="createpost" name="createpost" value="Create Post">
    </form>
    </div>';



  
    
}

include 'footer.php';
?>