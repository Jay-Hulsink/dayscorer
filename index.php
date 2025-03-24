<?php

$show_or_hide = "hidden";
$popup = "";
$dayfocus = "No data yet";
$dayscore = "";

require "conn.php";

$current_day = date('l');


session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header("location: login.php");
    exit();
}


if (isset($_GET['new'])) {
    if ($_GET['new'] == 0) {
        $_SESSION['newuser'] = false;
        header("location: myday.php");
        exit;
    }
}
if (isset($_SESSION['newuser']) && $_SESSION['newuser'] == true) {
    $show_or_hide = "";

}
if (!isset($_SESSION['newuser']) || $_SESSION['newuser'] == false) {
    $qry = $connect->prepare("SELECT score, highlight FROM table_of_id_" . $_SESSION['loggedInUser']);
    $qry->execute();
    $data = $qry->fetchAll();
    if ($data) {
        $data = $data[0];
        foreach($data as $num => $val) {
            if (is_numeric($num)) {
                unset($data[$num]);
            } else {
                $data[$num] = $val;
            } 
        }
    }
}
if (isset($data['score']) && is_numeric($data['score'])) {
    $data['highlight'] = "Your highlight of today: " . $data['highlight'];
}
if (!isset($data['score'])) {
    $data['score'] = '';
    $data['highlight'] = 'No data yet';
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dayscorer - home</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav>
            <button class="button_small"><a href="howto.php">How-to</a></button>
            <button class="button_small"><a href="myday.php">My day</a></button>
            <button class="button_small"><a href="index.php">Home</a></button>
            <button class="button_small"><a href="login.php?logout">Logout</a></button>
        </nav>
        <div <?=$show_or_hide?>class='popup'>
            <p <?=$show_or_hide?>>You seem to be a new user, 
            do you want a guide to how this site works? if not, you can always find
            the how-to page through the buttons at the top.</p>
            <button <?=$show_or_hide?>><a <?=$show_or_hide?> href='howto.php'>yes</a></button>
            <button <?=$show_or_hide?>><a <?=$show_or_hide?> href='index.php?new=0'>no</a></button>
        </div>
        <div class="content">
            <div class="panel">
                <div class="summary">
                    <h2><?=$data['score']?></h2>
                    <h3><?=$data['highlight']?></h3>
                </div>
            </div>
        </div>
        <footer>
            <h1>Dayscorer</h1>
            <h3>Current day: <?=$current_day?></h3>
        </footer>
    </body>
</html>