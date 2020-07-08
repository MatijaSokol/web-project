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