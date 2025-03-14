<?php
$show_or_hide = "hidden";
$popup = "";
$dayfocus = "";
$dayscore = "";
session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header("location: login.php");
}
if (isset($_GET['new'])) {
    if ($_GET['new'] == 0) {
        $_SESSION['newuser'] = false;
    }
}
if (isset($_SESSION['newuser']) && $_SESSION['newuser'] == true) {
    $show_or_hide = "";
}
if (isset($my_dayta)) {
    $dayfocus = "Your focus of the day: ";
} 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dayscorer - main page</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav><button class="button_small"><a href="howto.php">How-to</a></button></nav>
        <div <?=$show_or_hide?>class='popup'>
            <p <?=$show_or_hide?>>You seem to be a new user, 
            do you want a guide to how this site works? if not, you can always find
            the how-to page through the buttons at the top.</p>
            <button <?=$show_or_hide?>><a <?=$show_or_hide?> href='howto.php'>yes</a></button>
            <button <?=$show_or_hide?>><a <?=$show_or_hide?> href='index.php?new=0'>no</a></button>
        </div>
        <div class="content">
            <div class="panel"><div class="summary"><h2><?=$dayscore?></h2>
        <p><?=$dayfocus?></p></div></div>
        </div>
    </body>
</html>