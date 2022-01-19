<?php
// logout.php

include 'header.php';

// if not logged in
if (session_id() == '' || !isset($_SESSION['signed_in'])) {  
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


  echo '
    <div class="alert green">
      <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
      <strong>Success!</strong> You have been logged out.
    </div>
  ';
  

  // redirect to startpage
  header('Refresh: 2; URL = /forumsec/');
}

include 'footer.php';
?>