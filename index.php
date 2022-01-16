<?php
// index.php

include_once 'dbconnect.php';
include 'header.php';

// if sid exists and login for sid exists
session_start(); // gets session id 
if (session_id() == '' || !isset($_SESSION['signed_in'])) { // if not logged in 
    echo'

    <h1>Welcome to our forum - come join us!</h1><br>
    <h2>Here we offer you:</h2> <br>
    - your personal account <br><br>
    - the opportunity to create posts and share you thoughts with the whole community <br><br>
    - the possibilty of expressing your opinion by up- or downvoting posts <br><br><br>
    <h4>What are you waiting for?</h4>
    
    <div class="alert yellow">
        <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>
        <b>You are currently not logged in.</b><br>
        You can log in <a href="/forumsec/login.php">here</a> or register <a href="/forumsec/register.php">here</a> to create an account.
    </div>
    ';

} else { // if logged in 

    // action: create post
    if(isset($_POST['createpost']))
    {
        $title = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['title']));
        $text = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['text']));

        // check if input is too long
        if(strlen($title) > 100){$inputError .= "Title is too long!<br>";}
        if(strlen($text) > 2000){$inputError .= "Text is too long!<br>";}

        if($inputError){
            echo '<div class="alert red">
                <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
            echo "<b>Error:</b> $inputError
                </div>";
        }else{
            $author = $_SESSION['user_id'];
            $sql = "INSERT INTO post (title, content, author) VALUES ('$title','$text', '$author');";
            if (mysqli_query($conn, $sql)) {
                echo '
                <div class="alert green">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                    <strong>Success!</strong> Post has been sent.
                </div>
                ';
            } else {
                echo '
                <div class="alert red">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                    <strong>Error:</strong> unexpected SQL error.
                </div>
                ';
            }
        }
    }

    
    if (isset($_GET['action']) & isset($_GET['post'])) {
        $action = $_GET['action'];
        $post = $_GET['post'];
        $user = $_SESSION['user_id'];
        switch ($action){
            case 'delete': // delete specific post
                if ($_SESSION['is_admin']){
                    $sql_delete = "DELETE FROM `post` WHERE `post`.`post_id` = $post";
                    mysqli_query($conn, $sql_delete);
                }
                break;

            // TODO: scroll back to post
            case 'upvote': // upvote specific post
                // check if user already voted:
                $sql_check = "SELECT `vote` FROM `user_post` WHERE `user_id` = '$user' AND `post_id` = '$post'";
                if($res = mysqli_query($conn, $sql_check)){
                    if (mysqli_num_rows($res) == 0) { // if there is no upvote yet
                        $sql_vote = "INSERT INTO `user_post` (`user_post_id`, `user_id`, `post_id`, `vote`) VALUES (NULL, '$user', '$post', '+1')";
                    }else{
                        $sql_vote = "UPDATE `user_post` SET `vote` = '+1' WHERE `user_post`.`user_id` = '$user' AND `user_post`.`post_id` = '$post'";
                    }
                    mysqli_query($conn, $sql_vote);
                }
                break;

            // TODO: scroll back to post
            case 'downvote': // downvote specific post
                // check if user already voted:
                $sql_check = "SELECT `vote` FROM `user_post` WHERE `user_id` = '$user' AND `post_id` = '$post'";
                if($res = mysqli_query($conn, $sql_check)){
                    if (mysqli_num_rows($res) == 0) { // if there is no upvote yet
                        $sql_vote = "INSERT INTO `user_post` (`user_post_id`, `user_id`, `post_id`, `vote`) VALUES (NULL, '$user', '$post', '-1')";
                    }else{
                        $sql_vote = "UPDATE `user_post` SET `vote` = '-1' WHERE `user_post`.`user_id` = '$user' AND `user_post`.`post_id` = '$post'";
                    }
                    mysqli_query($conn, $sql_vote);
                }
                break;
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
            
            echo "<a href='?action=upvote&post=$post_id'><i class='material-icons'>expand_less</i></a><br>"; // upvote
            if ($row['votes'] <> NULL) {
                echo "$row[votes]";
            }else{
                echo "0";
            }
            echo "<br><a href='?action=downvote&post=$post_id'><i class='material-icons'>expand_more</i></a><br>"; // downvote

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
        echo '
                <div class="alert red">
                    <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
                    <strong>Error:</strong> unexpected SQL error.
                </div>
                ';
    }

}

include 'footer.php';
?>