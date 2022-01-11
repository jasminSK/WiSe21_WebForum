<?php
// index.php

include_once 'dbconnect.php';
include 'header.php';

// if sid exists and login for sid exists
session_start(); // gets session id 
if (session_id() == '' || !isset($_SESSION['signed_in'])) { // if not logged in 
    echo'<br>You are currently not logged in login <a href="./login.php">here</a>.';
} else { // if logged in 
    echo "<div class='account'>";
    echo "<h1>Account:</h1>";
    echo "<img src='upload/default.png'><br>";
    echo "username: " . $_SESSION['username'] . "<br>";
    echo "user_id: " . $_SESSION['user_id'] . "<br>";
    echo "logged_in: " . $_SESSION['signed_in'] . "<br>";
    echo "admin: " . $_SESSION['is_admin'] . "<br>";
    echo "</div>";

    // HTML - Form for uploading files
    // Type "file" enables file browsing
    echo '
    <form action="" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit_picture">
    </form>
    ';

    // PHP - Code for file upload
    // ATTENTION: The uploaded files will be saved in the directory "upload"
    if(isset($_POST["submit_picture"])) {

        $target_dir = "upload/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Checks if image is really an image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "<div>File is an image - " . $check["mime"] . ".</div>";
            $uploadOk = 1;
        } else {
            echo "<div>File is not an image.</div>";
            $uploadOk = 0;
        }

        // Checks if file already exists
        if (file_exists($target_file)) {
            echo "<div>Sorry, file already exists.</div>";
            $uploadOk = 0;
        }

        // Checks if file size > 500KB
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "<div>Sorry, your file is too large.</div>";
            $uploadOk = 0;
        }

        // Allows only certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
            echo "<div>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</div>";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        // Else, if everything is ok, try to upload file or send error message if something went wrong
        if ($uploadOk == 0) {
            echo "<div>Sorry, your file was not uploaded.</div>";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "<div> The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded. </div>"; 
            } else {
                echo "<div>Sorry, there was an error uploading your file.</div>";
            }
        }
    }

}

include 'footer.php';
?>