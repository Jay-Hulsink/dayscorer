<?php
require("conn.php");
$pass = "";
$warn = "Ñ";
$hide = 'hidden';

session_start();

if (isset($_GET['logout'])) {
    session_destroy();
}


$current_day = date('l');

if (isset($_POST['log']) && $_POST['login_username'] != "" && $_POST['login_pass'] != "") {
    $fetch = $connect->prepare("SELECT id, pass FROM users WHERE username = ?");
    $fetch->execute([$_POST['login_username']]);
    $fetch = $fetch->fetchAll();
    if (count($fetch) == 0) {
        $warn = "No user found by that name";
        $hide = '';
    } else {
        $fetch = $fetch[0];
        $id = $fetch[0];
        $pass = $fetch[1];
        if(password_verify($_POST['login_pass'], $pass)) {
                session_start();
                intval($id);
                $_SESSION['loggedInUser'] = $id;
                header("location: index.php");
                exit();
        } else {
            $warn = "Incorrect username/password combination";
            $hide = '';
        }
    }
}
if (isset($_POST['sign']) && isset($_POST['username']) && $_POST['username'] != "" && isset($_POST['pass_first']) && $_POST['pass_first'] != "" &&
    isset($_POST['pass_repeat']) && $_POST['pass_first'] == $_POST['pass_repeat']) {

    $fetch = $connect->prepare("SELECT username FROM users WHERE username = ?");
    $fetch->execute([$_POST['username']]);
    $fetch = $fetch->fetchAll();
    if (count($fetch) == 0) {     
        $username = $_POST['username'];
        $usercreation = $connect->prepare("INSERT INTO users (username, pass) VALUES (?, ?);");
        $usercreation->execute([$username, password_hash($_POST['pass_first'], PASSWORD_DEFAULT)]);
        $fetch = $connect->prepare("SELECT id FROM users where username = ?");
        $fetch->execute([$username]);
        $fetch = $fetch->fetch();
        $id = $fetch['id'];
        $str_id = strval($id); 
        $tablename = "table_of_id_" . $str_id;
        $usertablecreation = $connect->prepare("CREATE TABLE table_of_id_$str_id (dayname varchar(128), score int, sleep int, work int, rest int, outside int, highlight varchar(128), userscore int, weekofyear int);");
        $usertablecreation->execute();
        session_start();
        intval($id);
        $_SESSION['loggedInUser'] = $id;
        $_SESSION['newuser'] = 1;
        header("location: index.php");
        exit();
    } else {
        $warn = "Username already taken, please try a different username";
        $hide = '';
    }
}
if (isset($_POST['pass_first']) && isset($_POST['pass_repeat']) && $_POST['pass_first'] != $_POST['pass_repeat']) {
    $warn = "Passwords do not match";
    $hide = '';
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dayscorer - login</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <script src="gsap.min.js"></script>
        <nav><h1>Dayscorer</h1></nav>
        <p <?=$hide?> class="warn"><?=$warn?></p>
            <h2>Please Login</h2>
                <form id="loginform" method="post">
                    <input type="text" name="login_username" placeholder="username">
                    <input type="password" name="login_pass" placeholder="password">
                    <input class="submit_button" type="submit" name="log" value="log in">
                </form>
            <h2>Don't have an account? Sign up here</h2>
                <form id="signupform" method="post">
                    <input type="text" name="username" placeholder="username">
                    <input type="password" name="pass_first" placeholder="password">
                    <input type="password" name="pass_repeat" placeholder="repeat password">
                    <input class="submit_button" type="submit" name="sign" value="sign up">
                </form>
            <script>
                gsap.from("#loginform", {x: -3000, duration: 1});
                gsap.from("#signupform", {x: -3000, duration: 1});
                gsap.from("h2", {x: -3000, duration: 1, ease: "bounce.out"})
                gsap.from("h1", {y: -500, duration: 1, ease: "bounce.in"})
            </script>
    </body>
</html>