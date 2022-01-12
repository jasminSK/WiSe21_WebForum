<?php
// footerPages.php
include 'header.php';

//TODO: doesn't work yet, only shows default

echo '<div>';

if (isset($_GET['site'])) {
    $site = $_GET['site'];
} else {
    $site = '0';
}

switch ($site){
    case 'contactus':
        echo 'Yea';
        break;
    default:
        echo 'Nope';
}
echo'</div>';


include 'footer.php';
?>