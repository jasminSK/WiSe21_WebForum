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
        echo 'contact us';
        break;
    case 'faq':
        echo 'faq';
        break;
    case 'aboutus':
        echo 'about us';
        break;
    default:
        echo 'Nope';
}
echo'</div>';


include 'footer.php';
?>