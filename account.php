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
    $file_path = $_SESSION['file_path'];
    $is_admin = $_SESSION['is_admin'];

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

    </div>
    ";

    // PHP - Code for file upload
    /* 
        TODO:
        - rename file
        - update file_path in db 
        - update session cookie file_path
        - rescale image to (500px x 500px)
        
    */
    // ATTENTION: The uploaded files will be saved in the directory "upload"
    if(isset($_POST["submit_picture"])) {

        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Checks if file path has been selected
        if(empty($target_file) OR empty($imageFileType)){
            echo '<div class="message">';
            echo "Please select a file first<br>";
            echo '</div>';
        } else { //if file selected
            echo '<div class="message">';
    
            // Checks if image is really an image
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".<br>";
                $uploadOk = 1;
            } else {
                echo "File is not an image.<br>";
                $uploadOk = 0;
            }

            // Checks if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.<br>";
                $uploadOk = 0;
            }

            // Checks if file size > 500KB
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.<br>";
                $uploadOk = 0;
            }

            // Allows only certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            // Else, if everything is ok, try to upload file or send error message if something went wrong
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.<br>";
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.<br>"; 
                } else {
                    echo "Sorry, there was an error uploading your file.<br>";
                }
            }
            echo '</div>';

        }

    }

}

include 'footer.php';
?>