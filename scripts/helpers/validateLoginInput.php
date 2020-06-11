<?php

    if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
        header("Location: ../main/main.php");
    }

    require_once 'Validator.php';

    $userJSON = $_POST["user"];
    $user = json_decode($userJSON);

    $validator = Validator::getInstance();

    $username = $user->username;
    $validUsername = $validator->validateText($username);
    if (!$validUsername) {
        echo "username";
        die();
    }

    $password = $user->password;
    $validPassword = $validator->validateText($password);
    if (!$validPassword) {
        echo "password";
        die();
    }

    echo "Success";

?>