<?php

    if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
        header("Location: ../main/main.php");
    }

    require_once 'Validator.php';

    $query = $_POST["query"];

    $validator = Validator::getInstance();

    $validQuery = $validator->validateText($query);
    if (!$validQuery) {
        echo "Error";
        die();
    }

    echo "Success";

?>