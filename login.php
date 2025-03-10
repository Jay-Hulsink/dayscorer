<?php 

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dag 'o meter - login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1>Please Login</h1>
            <form method="post">
                <input type="text" name="login_username" placeholder="username">
                <input type="password" name="login_pass" placeholder="password">
            </form>

        <h2>Don't have an account? Sign up here</h2>
            <form method="post">
                <input type="text" name="username" placeholder="username">
                <input type="password" name="pass_first" placeholder="password">
                <input type="password" name="pass_repeat" placeholder="repeat password">
            </form>
    </body>
</html>