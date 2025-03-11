<?php
require("conn.php");
$pass = "";
$warn = "";

if (isset($_POST['log']) && $_POST['login_username'] != "" && $_POST['login_pass'] != "") {
    $fetch = $connect->prepare("SELECT id, pass FROM users WHERE username = ?");
    $fetch->execute([$_POST['login_username']]);
    $fetch = $fetch->fetchAll();
    if (count($fetch) == 0) {
        $warn = "No user found by that name";
    } else {
        $fetch = $fetch[0];
        // var_dump($fetch);   
        $id = $fetch[0];
        // var_dump($id);
        $pass = $fetch[1];
        if(password_verify($_POST['login_pass'], $pass)) {
                session_start();
                intval($id);
                $_SESSION['loggedInUser'] = $id;
                header("location: index.php");
                exit();
        } else {
            $warn = "Incorrect username/password combination";
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
        // var_dump($fetch);
        $id = $fetch['id'];
        $str_id = strval($id); 
        $tablename = "table_of_id_" . $str_id;
        $usertablecreation = $connect->prepare("CREATE TABLE `?` (score int, focus enum('free time', 'travel', 'work', 'sleep'), achievement varchar(128), userscore int);");
        $usertablecreation->execute([$tablename]);
    } else {
        $warn = "Username already taken, please try a different username";
    }
}
if (isset($_POST['pass_first']) && isset($_POST['pass_repeat']) && $_POST['pass_first'] != $_POST['pass_repeat']) {
    $warn = "Passwords do not match";
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