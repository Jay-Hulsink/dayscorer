<?php

session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header("location: login.php");
    exit();
}
require "conn.php";

$current_day = date('l');
$current_week = date('W');

$dayscore = 0;
$user_calc_data = $connect->prepare("SELECT * FROM weekdata WHERE userid = ? AND dayname = ?;");
if ($user_calc_data) {
    $user_calc_data->execute([$_SESSION['loggedInUser'], $current_day]);
    $user_calc_data = $user_calc_data->fetchAll();
    $user_calc_data = $user_calc_data[0];
    foreach($user_calc_data as $num => $data) {
        if (is_numeric($num)) {
                unset($user_calc_data[$num]);
        } else {
            $user_calc_data[$num] = $data;
        } 
    }
    if ($user_calc_data['sleep'] > 6 || $user_calc_data['sleep'] < 10) {
        $dayscore += 15;
    }
    if ($user_calc_data['rest'] == 1) {
        $dayscore += 15;
    }
    if ($user_calc_data['work'] < 10) {
        $dayscore += 15;
    }
    if ($user_calc_data['outside'] > 1) {
        $dayscore += 15;
    }
    $dayscore += ($user_calc_data['userscore'] * 4);
}
if ($dayscore) {
    $qry = $connect->prepare("UPDATE weekdata SET score = ? WHERE userid = ? AND dayname = ?");
    $qry->execute([$dayscore, $_SESSION['loggedInUser'], $current_day]);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dayscorer - Reveal</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <script src="gsap.min.js"></script>
        <nav>
            <a class="button_small" href="howto.php">How-to</a>
            <a class="button_small" href="myday.php">My day</a>
            <a class="button_small" href="index.php">Home</a>
            <a class="button_small" href="login.php?logout">Logout</a>
        </nav>        
        <div class="content">
            <h2 id="fromtop">Your dayscore is.....</h2>
            <div class="scorecontainer">
            <div class="progress_bar_background">
                <div class="progress_bar" style="width: <?=$dayscore?>%;">
                    <h3 class="big_h3"><?=$dayscore?></h3>
                </div>
            </div>
            <h2>Your highlight of today is:</h2>
                <h3 class="big_h3">'<?=$user_calc_data['highlight']?>'</h3>
            </div>
        </div>
        <footer>
            <div class="spread">
                <h3 class="centre"> Current day: <?=$current_day?></h3>
                <h1>Dayscorer</h1>
                <h3 class="centre">current week of the year: <?=$current_week?></h3>
            </div>
        </footer>
        <script>
            gsap.from('.content', {x: -1500});
            gsap.from('.button_small', {y: -1000});
        </script>
    </body>
</html>