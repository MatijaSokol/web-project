<?php

    if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
        header("Location: ../main/main.php");
    }

    require_once 'Validator.php';

    $userJSON = $_POST["user"];
    $user = json_decode($userJSON);

    $validator = Validator::getInstance();

    $firstname = $user->firstname;
    $validFirstName = $validator->validateText($firstname);
    if (!$validFirstName) {
        echo "FirstName";
        die();
    }

    $lastname = $user->lastname;
    $validLastName = $validator->validateText($lastname);
    if (!$validLastName) {
        echo "LastName";
        die();
    }

    $username = $user->username;
    $validUsername = $validator->validateText($username);
    if (!$validUsername) {
        echo "Username";
        die();
    }

    $password = $user->password;
    $validPassword = $validator->validateText($password);
    if (!$validPassword) {
        echo "Password";
        die();
    }

    $email = $user->email;
    $validEmail = $validator->validateText($email);
    if (!$validEmail) {
        echo "Email";
        die();
    }

    $validEmail = $validator->validateEmail($email);
    if (!$validEmail) {
        echo "Email";
        die();
    }

    echo "Success";

?>