<?php
// footerPages.php

include 'header.php';

echo '<div>';

if (isset($_GET['site'])) {
    $site = $_GET['site'];
} else {
    $site = '0';
}

switch ($site){
    case 'contactus':
        echo '
            <div class="top-part">
                <h5>Contact Us</h5><br>
                <h6>Reach out to us!</h6>
            </div>
            ';
        echo '
            <div>
                <div class="lower left-part">
                    <h7>Need help?</h7><br>
                    Call us: +49 123412341234<br>
                    E-mail us: crazysupport@mail.com
                </div>
                <div class="lower right-part">
                    <h7>Business proposals.</h7><br>
                    Call us: +49 432143214321<br>
                    E-mail us: crazybusiness@mail.com
                </div>
            </div>
        ';
        break;
    case 'faq':
        echo '
            <div class="top-part">
                <h5>Frequently Asked Questions</h5><br>
                <h6>But only hypothetical</h6>
            </div>
        ';
        echo '
            <div class="lower middle">
                <picture>
                    <img src="./src/nobody_got_time.png" alt="Aint nobody got time for that" style="height:250px;">
                </picture> 
            </div>
        ';
        break;
    case 'aboutus':
        echo '
            <div class="top-part">
                <h5>About Us</h5><br>
                <h6>Not that interesting tbh</h6>
            </div>
        ';
        echo '
            <div class="lower middle">
                <h7>We are Noah, Lisa and Jasmin.</h7><br>
                <picture>
                    <img src="./src/confetti.gif" alt="confetti" style="height:200px;">
                </picture>
            </div>
        ';
        break;
    default:
        echo 'Oops, something went wrong.<br>
            How did you even get here?<br>
            Please return via Home button.
        ';
}
echo'</div>';

include 'footer.php';
?>