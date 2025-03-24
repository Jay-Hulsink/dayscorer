<?php

session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header("location: login.php");
    exit();
}

$current_day = date('l');

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dayscorer - How-to</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav>
            <button class="button_small"><a href="howto.php">How-to</a></button>
            <button class="button_small"><a href="myday.php">My day</a></button>
            <button class="button_small"><a href="index.php">Home</a></button>
            <button class="button_small"><a href="login.php?logout">Logout</a></button>
        </nav>        
        
        <div class="content">
            <h1 id="fromtop">How-to</h1>
            
        </div>
        <footer>
            <h1>Dayscorer</h1>
            <h3>Current day: <?=$current_day?></h3>
        </footer>
    </body>
</html>