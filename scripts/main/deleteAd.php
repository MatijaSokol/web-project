<?php

require_once '../db/MyPDO.php';
require_once '../db/ProductDbHelper.php';

$id = $_GET['id'];

$myPdo = MyPDO::getInstance();
$productDbHelper = ProductDbHelper::getInstance($myPdo);

$ad = $productDbHelper->findAdById($id);
$image = $ad->image;

$valid = $productDbHelper->deleteAdById($id);

if ($valid) {
    header("Location: myAds.php");
    unlink($image);
}