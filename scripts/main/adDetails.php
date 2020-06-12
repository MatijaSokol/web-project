<?php

require_once '../db/MyPDO.php';
require_once '../db/ProductDbHelper.php';

$id = $_GET['id'];

$myPdo = MyPDO::getInstance();
$productDbHelper = ProductDbHelper::getInstance($myPdo);

$ad = $productDbHelper->findAdById($id);

echo $ad->name . '<br>';
echo $ad->description . '<br>';
echo $ad->price . '<br>';
echo $ad->owner . '<br>';
echo $ad->image . '<br>';