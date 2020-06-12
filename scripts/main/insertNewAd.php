<?php 

require_once '../db/MyPDO.php';
require_once '../db/ProductDbHelper.php';
require_once '../model/Product.php';

$adJSON = $_POST['ad'];
$ad = json_decode($adJSON);

$name = $ad->name;
$description = $ad->description;
$price = $ad->price;
$owner = $ad->owner;
$image = $ad->image;

$mypdo = MyPDO::getInstance();
$productDbHelper = ProductDbHelper::getInstance($mypdo);

$product = new Product($name, $description, $price, $owner, $image);

$valid = $productDbHelper->insertAd($product);

if ($valid) {
    echo "success";
} else {
    echo "error";
}