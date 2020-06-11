<?php

    if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
        header("Location: main.php");
    }

    session_start();
    session_destroy();
    if(isset($_COOKIE['username']) and isset($_COOKIE['password'])) {
        $username = $_COOKIE['username'];
        $password  = $_COOKIE['password'];
        setcookie('username', $username);
        setcookie('password', $password);
        unset($username);
        unset($password);
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <h1>Logout script</h1>
        <p>
            You have succesfully logged out.
        </p>
        <p>
            Click here to <a href="index.php">login again</a>.
        </p>
    </body>
</html>