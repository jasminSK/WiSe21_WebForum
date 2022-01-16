<?php
// logout.php


// start session
session_start();
if (session_id() == '' || !isset($_SESSION['signed_in'])) { // if not logged in 
  // redirect to startpage
   header('Refresh: 0; URL = /forumsec/');
}else{
  // remove all session variables
  session_unset();

  // send browser command remove sid from cookie
  setcookie(session_name(), "", time() - 3600); 

  // remove sid-login from server storage
  session_destroy();

  // end the current session and store session data
  session_write_close();

  include 'header.php';
  echo '
    <div class="alert green">
      <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
      <strong>Success!</strong> You have been logged out.
    </div>
  ';

  include 'footer.php';

  // redirect to startpage
  header('Refresh: 2; URL = /forumsec/');
}
?>