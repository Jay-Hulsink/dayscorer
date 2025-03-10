<?php
require("conn.php");

$warn = "";

if (isset($_POST['log']) && isset($_POST['login_username']) && isset($_POST['login_pass'])) {
    $id = $connect->prepare("SELECT id FROM users WHERE username = ? AND pass = ?");
    $id->execute([$_POST['username'], $_POST['login_pass']]);
    $id = $id->fetch();
    $id = $id[0];
    if (is_int($id)) {
        session_start();
        $_SESSION['loggedInUser'] = $id;
        header("location: index.php");
        exit();
    }
}
if (isset($_POST['sign']) && isset($_POST['username']) && isset($_POST['pass_first']) && isset($_POST['pass_repeat']) && $_POST['pass_first'] == $_POST['pass_repeat']) {
    $id = $connect->prepare("SELECT id FROM users WHERE username = ?");
    $id->execute([$_POST['username']]);
    $id = $id->fetch();
    if ($id) {
        $id = $id[0];
        if (is_int($id)) {
            $warn = "Username already taken, please try a different username";
        }
    } else {
        $usertablecreation = $connect->prepare("");
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dayscorer - login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="top_bar"><h1>Dayscorer</h1></div>
        <h2 class="warn"><?=$warn?></h2>
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