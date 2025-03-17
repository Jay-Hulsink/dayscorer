<?php

$show_page_one = 'hidden';
$show_page_two = 'hidden';
$show_page_three = 'hidden';
$show_page_four = 'hidden';

session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header("location: login.php");
}
if (!isset($_POST['submit_2']) && !isset($_POST['submit_3']) && !isset($_POST['submit_4'])) {
    $show_page_one = '';
    $page = 2;
}
if (isset($_POST['submit_2']) && $_POST['submit_2'] ==  "Next page") {
    $show_page_two = '';
    $page = 3;
}
if (isset($_POST['submit_3']) && $_POST['submit_3'] == "Next page") {
    $show_page_three = '';
    $page = 4;
}
if (isset($_POST['submit_4']) && $_POST['submit_4'] == "Next page") {
    $show_page_four = '';
}

$current_day = date('l');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dayscorer - My day</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav><h1>Dayscorer</h1></nav>
        
        <h1 id="fromtop">How was your day</h1>
        <div class="content">
            <form id='dayform' method="post">
                <h2 <?=$show_page_one?>>
                    How many hours have you spent:
                </h2>
                <h2 <?=$show_page_two?>>
                    What was your highlight of today?
                </h2>
                <h2 <?=$show_page_three?>>
                    What would you score today as?
                </h2>
                <div class="rowww">
                    <h3 <?=$show_page_three?>>
                        Awful
                    </h3>
                    <h3 <?=$show_page_three?>>
                        Out of 10
                    </h3>
                    <h3 <?=$show_page_three?>>
                        Great
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
                            resting
                        </th>
                        <th <?=$show_page_one?>>
                            outside
                        </th>
                    </tr>
                    <tr <?=$show_page_one?>>
                        <td <?=$show_page_one?>>
                            <input min="0" max="24" class="field" type="number" <?=$show_page_one?>>
                        </td>
                        <td <?=$show_page_one?>>
                            <input min="0" max="24" class="field" type="number" <?=$show_page_one?>>
                        </td>
                        <td <?=$show_page_one?>>
                            <input min="0" max="24" class="field" type="number" <?=$show_page_one?>>
                        </td>
                        <td <?=$show_page_one?>> 
                            <input min="0" max="24" class="field" type="number" <?=$show_page_one?>>
                        </td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td class="big_td">
                            <input class="textfield" type="text" <?=$show_page_two?>>
                        </td>
                    </tr>
                    <tr>
                        <td class="slider">
                            <input type="range" min="0" max="10" class="slider" <?=$show_page_three?>>
                        </td>
                    </tr>
                </table>
                <input id="margtop" class="submit_button" type="submit" name="submit_<?=$page?>" value="Next page">
            </form>
        </div>
        <footer>
            <h3>
                Current day: <?=$current_day?>
            </h3>
        </footer>
    </body>
</html>