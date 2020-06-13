<?php

if (!($_SERVER["REQUEST_METHOD"] === "POST")) {
    header("Location: ../main/main.php");
}

require_once 'Validator.php';

$adJSON = $_POST['ad'];
$ad = json_decode($adJSON);

$validator = Validator::getInstance();

$name = $ad->name;

$validName = $validator->validateText($name);
if (!$validName) {
    echo "name";
    die();
}

$description = $ad->description;
$validDescription = $validator->validateText($description);
if (!$validDescription) {
    echo "description";
    die();
}

$price = $ad->price;
$validPrice = $validator->validateText($price);
if (!$validPrice) {
    echo "price";
    die();
}

echo "Success";

