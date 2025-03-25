<?php

session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header("location: login.php");
    exit();
}

$current_day = date('l');
$current_week = date('W');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dayscorer - How-to</title>
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
            <h1 id="fromtop">How-to</h1>
            <ul>
                <li>This site allows you to fill in how your day has been, and gives you a score.</li>
                <li>you can navigate to the various pages through the buttons at the top.</li>
                <li>how-to is for explaining the site, its the page you are on</li>
                <li>my day is the page for filling in how your day was</li>
                <li>
                    home is for an overview of the current day as well as the current 
                    week of the year, both are visible at the bottom of the screen
                </li>
                <li>you can press logout to safely log out of your account</li>
            </ul>
            <p>Heads up! you can only fill in data of the current day, you can not fill it in the day after</p>
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