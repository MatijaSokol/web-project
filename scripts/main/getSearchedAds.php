<?php

require_once '../db/MyPDO.php';
require_once '../db/ProductDbHelper.php';

$query = $_POST['query'];

$myPdo = MyPDO::getInstance();
$productDbHelper = ProductDbHelper::getInstance($myPdo);

$products = $productDbHelper->findAllSearchedAds($query);

echo json_encode($products);


