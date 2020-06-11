<?php
    if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
        header("Location: ../main/main.php");
    }

    require_once '../db/MyPDO.php';
    require_once '../db/UserDbHelper.php';

    $mypdo = MyPDO::getInstance();
    $userDbHelper = UserDbHelper::getInstance($mypdo);
    $users = $userDbHelper->findAll();

    if (count($users) > 0) {
        $usernames = array_column($users, 'username');
        echo json_encode($usernames);
    } else {
        echo("Error");
    }
?>