<?php
// logout.php
session_start();
setcookie(session_name(), "", time() - 3600); //send browser command remove sid from cookie
session_destroy(); //remove sid-login from server storage
session_write_close();

include 'header.php';
echo '
<div class="alert green">
  <span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
  <strong>Success!</strong> You have been logged out.
</div>
';
include 'footer.php';

header('Refresh: 2; URL = /forum/');
?>