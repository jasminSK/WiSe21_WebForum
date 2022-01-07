<?php
# TODO: convert style to external css sheet

// index.php
include 'header.php';

echo '<div class="error"; style="color: #333; text-align: center;">';
echo '<a style="text-shadow: -5px 5px 15px #666; font-size: 10em; font-weight: 900;">Oops!</a><br>';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

} else {
    $id = '0';
}

# TODO: test error pages: 401, 402, 403, 500, 501, 502, 503, 503, 504
switch ($id){
    case '401':
        echo '<e style="font-size: 3em; font-weight: 900;">401 Unauthorized</e><br>';
        break;
    case '402':
        echo '<e style="font-size: 3em; font-weight: 900;">402 Payment Required<br>(lol as if)</e><br>';
        break;
    case '403':
        echo '<e style="font-size: 3em; font-weight: 900;">403 Forbidden<br>(lol as if)</e><br>';
        break;
    case '404':
        echo '<e style="font-size: 3em; font-weight: 900;">404 Not Found</e><br>';
        break;
    case '500':
        echo '<e style="font-size: 3em; font-weight: 900;">500 Internal Server Error</e><br>';
        break;
    case '501':
        echo '<e style="font-size: 3em; font-weight: 900;">501 Not Implemented</e><br>';
        break;
    case '502':
        echo '<e style="font-size: 3em; font-weight: 900;">502 Bad Gateway</e><br>';
        break;
    case '503':
        echo '<e style="font-size: 3em; font-weight: 900;">503 Service Unavailable</e><br>';
        break;
    case '504':
        echo '<e style="font-size: 3em; font-weight: 900;">504 Gateway Timeout</e><br>';
        break;
    default:
        echo '<e style="font-size: 3em; font-weight: 900;">unknown error</e><br>';
}

echo '</div>'; // end of error

include 'footer.php';
?>