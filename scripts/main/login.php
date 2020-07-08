<?php
    if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
        header("Location: main.php");
    }

    require_once '../db/MyPDO.php';
    require_once '../db/UserDbHelper.php';
    require_once '../model/User.php';

    $userJSON = $_POST["user"];
    $user = json_decode($userJSON);
    $username = $user->username;
    $password = $user->password;

    $remembered = $_POST["remember"];

    $mypdo = MyPDO::getInstance();
    $userDbHelper = UserDbHelper::getInstance($mypdo);
    $exist = $userDbHelper->findUserByUsernameAndPassword($username, md5($password));

    $userDbHelper->closeConnection();

    if (!$exist) {
        echo "Error - user does not exist";
    } else {
        if($remembered === "true") {
            setcookie('username', $username);
            setcookie('password', $password);
            setcookie('remember', "remembered");
        } else {
            setcookie('remember', "remembered", time() - 1);
        }
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['password']  = $password;
        echo "Success";
    }