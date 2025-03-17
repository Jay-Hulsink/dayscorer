<?php

session_start();
if (!isset($_SESSION['loggedInUser'])) {
    header("location: login.php");
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Dayscorer - How-to</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <nav></nav>
        
        <div class="content">
            <h1 id="fromtop">How-to</h1>
            
        </div>
    </body>
</html>