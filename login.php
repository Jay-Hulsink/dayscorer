<?php 

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dag 'o meter - login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="top_bar"><h1>Dayscorer</h1></div>
        <h2>Please Login</h2>
            <form method="post">
                <input type="text" name="login_username" placeholder="username">
                <input type="password" name="login_pass" placeholder="password">
                <input class="submit_button" type="submit" name="log" value="log in">
            </form>

        <h2>Don't have an account? Sign up here</h2>
            <form method="post">
                <input type="text" name="username" placeholder="username">
                <input type="password" name="pass_first" placeholder="password">
                <input type="password" name="pass_repeat" placeholder="repeat password">
                <input class="submit_button" type="submit" name="sign" value="sign up">
            </form>
    </body>
</html>