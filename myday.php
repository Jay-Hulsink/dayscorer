<?php

require "conn.php";

$show_page_one = 'hidden';
$show_page_two = 'hidden';
$show_page_three = 'hidden';
$show_page_four = 'hidden';
$hide_submit = '';

$current_day = date('l');
$current_week = date('W');
session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header("location: login.php");
    exit();
}
if (!isset($_POST['submit_2']) && !isset($_POST['submit_3']) && !isset($_POST['submit_4']) &&!isset($_POST['submit_4'])) {
    $show_page_one = '';
    $page = 2;
}
if (isset($_POST['submit_2']) && $_POST['submit_2'] ==  "Next page") {
    $show_page_two = '';
    $page = 3;
    $hide_submit = 'hidden';
    $insert = $connect->prepare("DELETE FROM table_of_id_" . $_SESSION['loggedInUser'] . " WHERE dayname = ?;");
    $insert->execute([$current_day]);
    $insert = $connect->prepare("INSERT INTO table_of_id_" . $_SESSION['loggedInUser'] . " (dayname, sleep, work, outside, weekofyear) VALUES (?, ?, ?, ?, ?);");
    $insert = $insert->execute([$current_day, $_POST['sleephours'], $_POST['workhours'], $_POST['outsidehours'], $current_week]);
}
if (isset($_POST['submit_3']) && $_POST['submit_3'] == 'no') {
    $show_page_three = '';
    $page = 4;
    $insert = $connect->prepare("UPDATE table_of_id_" . $_SESSION['loggedInUser'] . " SET rest = ? WHERE dayname = ?");
    $insert->execute([0, $current_day]);
}
if (isset($_POST['submit_3']) && $_POST['submit_3'] == 'yes') {
    $show_page_three = '';
    $page = 4;
    $insert = $connect->prepare("UPDATE table_of_id_" . $_SESSION['loggedInUser'] . " SET rest = ? WHERE dayname = ?");
    $insert->execute([1, $current_day]);
}
if (isset($_POST['submit_4']) && $_POST['submit_4'] == "Next page") {
    $show_page_four = '';
    $page = 5;
    $insert = $connect->prepare("UPDATE table_of_id_" . $_SESSION['loggedInUser'] . " SET highlight = ? WHERE dayname = ?;");
    $insert = $insert->execute([$_POST['highlight'], $current_day]);
}
if (isset($_POST['submit_5']) && $_POST['submit_5'] == "Next page") {
    $insert = $connect->prepare("UPDATE table_of_id_" . $_SESSION['loggedInUser'] . " SET userscore = ? WHERE dayname = ?;");
    $insert = $insert->execute([$_POST['userscore'], $current_day]);
    header("location: reveal.php");
    exit();   
}



?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dayscorer - My day</title>
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
            <form id='dayform' method="post">
                <h2 <?=$show_page_one?>>
                    How many hours have you spent:
                </h2>
                <h2 <?=$show_page_two?>>
                    Have you rested enough today?
                </h2>
                <h2 <?=$show_page_three?>>
                    What was your highlight of today?
                </h2>
                <h2 <?=$show_page_four?>>
                    What would you score today as?
                </h2>
                <div class="rowww">
                    <h3 <?=$show_page_four?>>
                        awful
                    </h3>
                    <h3 <?=$show_page_four?>>
                        great
                    </h3>
                </div>
                <table>
                    <tr class="table_header_row" <?=$show_page_one?>>
                        <th <?=$show_page_one?>>
                            on work
                        </th>
                        <th <?=$show_page_one?>>
                            sleeping
                        </th>
                        <th <?=$show_page_one?>>
                            outside
                        </th>
                    </tr>
                    <tr <?=$show_page_one?>>
                        <td <?=$show_page_one?>>
                            <input min="0" max="24" class="field" type="number" name="workhours" <?=$show_page_one?>>
                        </td>
                        <td <?=$show_page_one?>>
                            <input min="0" max="24" class="field" type="number" name="sleephours" <?=$show_page_one?>>
                        </td>
                        <td <?=$show_page_one?>> 
                            <input min="0" max="24" class="field" type="number" name="outsidehours" <?=$show_page_one?>>
                        </td>
                    </tr>
                    <tr>
                        <td hidden ></td>
                        <td class="big_td">
                            <input class="textfield" type="text" name="highlight" <?=$show_page_three?>>
                        </td>
                        <td hidden ></td>
                    </tr>
                    <tr>
                        <td hidden ></td>
                        <td class="slider">
                            <input type="range" min="0" max="10" class="slider" name="userscore" <?=$show_page_four?>>
                        </td>
                        <td hidden ></td>
                    </tr>
                </table>
                <input id="margtop_main" class="submit_button" type="submit" <?=$hide_submit?> name="submit_<?=$page?>" value="Next page">
                <div class="row_class">
                <input class="submit_button_2" type="submit" <?=$show_page_two?> name="submit_<?=$page?>" value="yes">
                <input  class="submit_button_2" type="submit" <?=$show_page_two?> name="submit_<?=$page?>" value="no">
                </div>
            </form>
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