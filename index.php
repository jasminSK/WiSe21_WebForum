<?php
// index.php

include_once 'dbconnect.php';
include 'header.php';

// if sid exists and login for sid exists
session_start(); // gets session id 
if (session_id() == '' || !isset($_SESSION['signed_in'])) { // if not logged in 
    echo'<br>You are currently not logged in login <a href="./login.php">here</a>.';
} else { // if logged in 

    // action: create post
    if(isset($_POST['createpost']))
    {
        $title = $_POST['title'];
        $text = $_POST['text'];
        $author = $_SESSION['user_id'];
        $sql = "INSERT INTO post (title, content, author) VALUES ('$title','$text', '$author');";
        if (mysqli_query($conn, $sql)) {
            echo '
            <div class="alert">
                <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                <strong>Success!</strong> Post has been sent.
            </div>
            ';
        } else {
            echo "SQL:<br>".$sql . "<h3>Error:</h3><br>" .mysqli_error($conn); // for security remove error message
        }
    }

    // Delete specific post
    if (isset($_GET['action']) & isset($_GET['post'])) {
        if ($_SESSION['is_admin']){
            $action = $_GET['action'];
            $post = $_GET['post'];
            $sql_action = "DELETE FROM `post` WHERE `post`.`post_id` = $post";
            mysqli_query($conn, $sql_action);
        }               
    }

        // HTML - form for writing and sending post
        echo'
        <div class="createpost">
        <form action="" method="post" id="submitpost">
            <input type="text" id="title" name="title" value="" placeholder="Title" required><br>
            <input type="text" id="text" name="text" value="" placeholder="Text" required><br>
            <input type="submit" id="createpost" class="createpost" name="createpost" value="Create Post">
        </form>
        </div>';
        echo "<hr>";

    // Selects all posts
    $sql = "SELECT post.creation_date, post.post_id, user.username, post.title, post.content FROM post LEFT JOIN user ON post.author = user.user_id ORDER BY creation_date DESC;";

    // Displays all posts
    if ($res = mysqli_query($conn, $sql)) {
        echo "<div class='window scroll forum'>";

        // Goes trough all rows and creates the post bubbles
        while ($row = mysqli_fetch_array( $res, MYSQLI_ASSOC))
        {   
            $creation_date = $row['creation_date'];
            $post_id = $row['post_id'];
            $username = $row['username'];
            $title= $row['title'];
            $content = $row['content'];

            echo "<div class='post'>";

            echo "<div class='left'>";

            // Vote
            // TODO: implement upvote downvote
            // Does not work with href or only php, must use jquery or javascript or both to execute event
            $sql_vote = "SELECT SUM(vote) AS 'votes' FROM user_post WHERE post_id = $post_id;";
            $result = mysqli_query($conn, $sql_vote);
            $row = mysqli_fetch_array( $result, MYSQLI_ASSOC);
            
            echo '<a href="expand_less"><i class="material-icons">expand_less</i></a><br>';
            if ($row['votes'] <> NULL) {
                echo "$row[votes]";
            }else{
                echo "0";
            }
            echo '<br><a href="expand_less"><i class="material-icons">expand_more</i></a><br>';

            // delete post
            if ($_SESSION['is_admin']){
                echo "<br><a href='?action=delete&post=$post_id'><i class='material-icons'>delete</i></a><br>";      
            }
            echo "</div>"; // end of left

            echo "<div class='right'>";
            echo "<h4>$title</h4>";
            echo "$content<br>";
            echo "By $username<br>";
            echo "$creation_date<br>";
            echo "</div>"; // end of right
            echo' <br style="clear:both;"/>'; // fixes problem where post is 0px

            echo "</div>"; // end of post

        }
        echo "</div>"; // end of forum scroll
        mysqli_free_result($res);

    }else {
        echo "ERROR: Could't execute<br>";
    }

}

include 'footer.php';
?>