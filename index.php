<?php
$show_or_hide = "";
$popup = "";
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
    $popup = "<div class='popup'>
    <p>You seem to be a new user, do you want a guide to how this site works? if not, you can always find
    the how-to page through the buttons at the top.</p>
    <button><a href='introduction.php'>yes</a></button>
    <button><a href='index.php?new=0'>no</a></button>
    </div>";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dayscorer - main page</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav></nav>
        <?=$popup?>
        <div class="content">
            
        </div>
    </body>
</html>