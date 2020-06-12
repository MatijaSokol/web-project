<?php

require_once '../db/MyPDO.php';
require_once '../db/ProductDbHelper.php';

$query = $_POST['query'];
$username = $_POST['username'];

$myPdo = MyPDO::getInstance();
$productDbHelper = ProductDbHelper::getInstance($myPdo);

$products = $productDbHelper->findAllMySearchedAds($query, $username);

echo json_encode($products);


