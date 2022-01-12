<?php
// index.php

include_once 'dbconnect.php';
include 'header.php';

// if sid exists and login for sid exists
session_start(); // gets session id 
if (session_id() == '' || !isset($_SESSION['signed_in'])) { // if not logged in 
    echo'<div class="alert">
    You are currently not logged in. You can log in <a href="./login.php">here</a>.
</div>';
} else { // if logged in 
    $signed_in = $_SESSION['signed_in'];
    $user_id = $_SESSION['user_id'];
    $username = $_SESSION['username'];
    $is_admin = $_SESSION['is_admin'];

    // get profile picture path
    $sql_pfp = "SELECT `file_path` FROM `user` WHERE `user_id` = '$user_id';";
    $result = mysqli_query($conn, $sql_pfp);
    $row = mysqli_fetch_array( $result, MYSQLI_ASSOC);
    $file_path = $row['file_path'];

    if($is_admin){
        $role = 'Administrator';
    }else{
        $role = 'regular user';
    }

    echo "
    <div class='account'>

        <form action='' method='post' enctype='multipart/form-data'>
            <h1>Account:</h1>

            <div class='profilepicture'>
                <label for='fileToUpload'>
                    <input type='file' name='fileToUpload' id='fileToUpload'>
                    <img src='$file_path'>
                </label>
                <div class='edit'><i class='material-icons'>edit</i></div>
            </div>
            
            <br><br>
            <b>$username</b><br>
            $role<br>
            
            <input type='submit' value='Upload Image' name='submit_picture'>
        </form>

    ";

    // PHP - Code for file upload
    // ATTENTION: The uploaded files will be saved in the directory "upload"
    if(isset($_POST["submit_picture"])) {

        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // error message
        echo '
            <div class="alert yellow">
                <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
        ';

        // Checks if file path has been selected
        if(empty($target_file) OR empty($imageFileType)){
            echo "Error: Please select a file first.<br>";

        } else { //if file selected
            // Checks if image is really an image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                // echo "Success: File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "Error: File is not an image.<br>";
                $uploadOk = 0;
            }

            // Checks if file already exists
            if (file_exists($target_file)) {
                echo "Error: File already exists.<br>";
                $uploadOk = 0;
            }

            // Checks if file size > 500KB
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Error: File is too large.<br>";
                $uploadOk = 0;
            }

            // Allows only certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                echo "Error: Only JPG, JPEG, PNG & GIF files are allowed.<br>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            // Else, if everything is ok, try to upload file or send error message if something went wrong
            if ($uploadOk == 0) {
                echo "Error: Your file was not uploaded.<br>";
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    // delete old file
                    if($file_path != 'upload/default.png'){
                        if (!unlink($file_path)) { 
                            echo ("Error: Your old old profile picture cannot be deleted.<br>");
                        } else { 
                            echo ("Success: Your old old profile picture has been deleted.<br>"); 
                        } 
                    }
                    // update path in db
                    $sql_path = "UPDATE `user` SET `file_path` = '$target_file' WHERE `user`.`user_id` = $user_id;";
                    mysqli_query($conn, $sql_path);
                    echo ("Success: You've updated your profile picture.<br>"); 
                    header('Refresh: 0; URL = ');

                } else {
                    echo "Error: There was an error uploading your file.<br>";
                }
            }
            

        }
        echo '</div>';// end of alert

    }

    echo'</div>';// end of account

}

include 'footer.php';
?>