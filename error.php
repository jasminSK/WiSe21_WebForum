<?php
// error.php

include 'header.php';

echo '<div class="error";>';
echo '<a class="error">Oops!</a><br>';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

} else {
    $id = '0';
}

switch ($id){
    case '401':
        echo '<e class="error-content">401 Unauthorized</e><br>';
        break;
    case '402':
        echo '<e class="error-content">402 Payment Required<br>(lol?)</e><br>';
        break;
    case '403':
        echo '<e class="error-content">403 Forbidden<br></e><br>';
        break;
    case '404':
        echo '<e class="error-content">404 Not Found</e><br>';
        break;
    case '500':
        echo '<e class="error-content">500 Internal Server Error</e><br>';
        break;
    case '501':
        echo '<e class="error-content">501 Not Implemented</e><br>';
        break;
    case '502':
        echo '<e class="error-content">502 Bad Gateway</e><br>';
        break;
    case '503':
        echo '<e class="error-content">503 Service Unavailable</e><br>';
        break;
    case '504':
        echo '<e class="error-content">504 Gateway Timeout</e><br>';
        break;
    default:
        echo '<e class="error-content">unknown error</e><br>';
}

echo '</div>'; // end of error

include 'footer.php';
?>