<?php

$show_or_hide = "hidden";
$hidestyle = 'style="background-color: #46695f00; box-shadow: none;"';
$popup = "";
$dayfocus = "No data yet";
$dayscore = "";
$show_1 = 'hidden';
$show_2 = 'hidden';
$closs = '';
$table_output = '';
$daydata['score'] = '0';
$daydata['highlight'] = 'No data yet';

require "conn.php";

$current_day = date('l');
$current_week = date('W');


session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header("location: login.php");
    exit();
}
if (!isset($_GET['week'])) {
        
    if (isset($_GET['new'])) {
        if ($_GET['new'] == 0) {
            $_SESSION['newuser'] = false;
        }
    }
    if (isset($_SESSION['newuser']) && $_SESSION['newuser'] == true) {
        $show_or_hide = "";
        $hidestyle = '';

    }
    if (!isset($_SESSION['newuser']) || $_SESSION['newuser'] == false) {
        $qry = $connect->prepare("SELECT score, highlight FROM weekdata WHERE userid = ?");
        $qry->execute([$_SESSION['loggedInUser']]);
        $daydata = $qry->fetchAll();
        if ($daydata) {
            $daydata = $daydata[0];
            foreach($daydata as $num => $val) {
                if (is_numeric($num)) {
                    unset($daydata[$num]);
                } else {
                    $daydata[$num] = $val;
                } 
            }
        }
    }
    if (isset($daydata['score']) && $daydata['highlight'] != 'No data yet') {
        $daydata['highlight'] = "Your highlight of today: " . $daydata['highlight'];
        $closs = 'class="progress_bar_background"';
        $dayscore = $daydata['score'];
             
    }
    if (!isset($daydata['score'])) {
        $daydata['highlight'] = 'No data yet';
        $daydata['score'] = 0;
        $dayscore = '';

    }
    $show_1 = '';
} else {
    $show_2 = '';
    $qry = $connect->prepare("SELECT dayname, score, work, sleep, rest, outside, highlight FROM weekdata WHERE userid = ? AND weekofyear = ?");
    $qry->execute([$_SESSION['loggedInUser'], $current_week]);
    $weekdata = $qry->fetchAll();
    $i = 0;
    if ($weekdata) {
        foreach ($weekdata as $slot) {
            foreach($weekdata[$i] as $num => $val) {
                if (is_numeric($num)) {
                    unset($weekdata[$i][$num]);
                } else {
                    $weekdata[$i][$num] = $val;
                } 
            }
            $i++;
        }
    }


foreach ($weekdata as $row) {
    $table_output .= '<tr class="dayrow"' .  $show_2 . '>';
    foreach ($row as $key => $val) {
        $table_output .= '<td class="daytd "' . $show_2 . '>' . $val . '</td>';
    }
    $table_output .= '</tr>';
}

}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dayscorer - home</title>
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
        <div class="popup" <?=$show_or_hide?> <?=$hidestyle?>>
            <p <?=$show_or_hide?>>You seem to be a new user, 
            do you want a guide to how this site works? if not, you can always find
            the how-to page through the buttons at the top.</p>
            <div class="org">
                <a <?=$show_or_hide?> class="button_small_2" href='howto.php'>yes</a>
                <a <?=$show_or_hide?> class="button_small_2" href='index.php?new=0'>no</a>
            </div>
        </div>
        <div class="content">
            <div class="panel">
                <table class="daytable" <?=$show_2?>>
                        <tr class="dayrow" <?=$show_2?>>
                            <th <?=$show_2?>>Day</th>
                            <th <?=$show_2?>>score</th>
                            <th <?=$show_2?>>hours of sleep</th>
                            <th <?=$show_2?>>hours of work</th>
                            <th <?=$show_2?>>enough rest</th>
                            <th <?=$show_2?>>Hours outside</th>
                            <th <?=$show_2?>>highlight of day</th>
                        </tr>
                        <?=$table_output?>
                    </table>
                <div <?=$closs?>>
                    <div <?=$show_1?> class="progress_bar" style="width: <?=$daydata['score']?>%;">
                        <p class="big_p" <?=$show_1?>><?=$dayscore?></p>
                    </div>
                </div>
                <div <?=$show_1?> class="summary">
                    <p <?=$show_1?>><?=$daydata['highlight']?></p>
                </div>
            </div>
            <div class="panel">
                <a href="index.php?week" <?=$show_1?> class="button_small_2">Go to weekview</a>
                <a href="index.php" <?=$show_2?> class="button_small_2">Go to dayview</a>
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
            gsap.from('.popup', {y: -1000});
        </script>
    </body>
</html>