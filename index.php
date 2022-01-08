<?php
// index.php

include_once 'dbconnect.php';
include 'header.php';

// if sid exists and login for sid exists
session_start(); // gets session id 
if (session_id() == '' || !isset($_SESSION['signed_in'])) { // if not logged in 
    echo'<br>You are currently not logged in login <a href="./login.php">here</a>.';
} else { // if logged in 
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
            echo "<h2>Post has been sent</h2><br>";
        } else {
            echo "SQL:<br>".$sql . "<h3>Error:</h3><br>" .mysqli_error($conn); // for security remove error message
        }
    }

    // Selects all posts
    // TODO: add upvotes / downvotes together
    $sql = "SELECT post.creation_date, user.username, post.title, post.content FROM post LEFT JOIN user ON post.author = user.user_id ORDER BY creation_date DESC;";
    // Displays all posts and puts it into a window
    if ($res = mysqli_query($conn, $sql)) {
        echo "<div class='window scroll forum'>";
        // Goes trough all rows and creates the post bubbles
        while ($row = mysqli_fetch_array( $res, MYSQLI_ASSOC))
        {   
            $creation_date = $row['creation_date'];
            $username = $row['username'];
            $title= $row['title'];
            $content = $row['content'];
            
            echo "<div class='post'>";

            // TODO: delete post if admin
            // DELETE FROM post WHERE post.post_id = $post_id;
            if ($_SESSION['is_admin']){
                echo '<a href="delete"><i class="material-icons">delete</i></a>';
            }
                echo "<h4>$title</h4>";
                echo "<div>$content</div>";
                echo "<div class='left'>By $username</div>";
                echo "<div class='right'>$creation_date</div>";
            echo "</div>"; // end of post
            echo "<br>";
        }
        echo "</div>"; // end of forum scroll
        mysqli_free_result($res);

    }else {
        echo "ERROR: Could not able to execute<br>";
    }
    

    // HTML - form for writing and sending post
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