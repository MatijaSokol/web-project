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

    $mypdo = MyPDO::getInstance();
    $userDbHelper = UserDbHelper::getInstance($mypdo);
    $exist = $userDbHelper->findUserByUsername($username);

    if ($exist) {
        echo "Error - username exist";
    } else {
        $newUser = new User($user->firstname, $user->lastname, $user->username, md5($user->password), $user->email);
        $valid = $userDbHelper->insertUser($newUser);
        if ($valid) {
            echo "Success";
        } else {
            echo "Error - failed to insert into database";
        }
    }
?>