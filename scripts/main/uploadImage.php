<?php

$filename = $_FILES['file']['name'];

$location = "../../img/" . $filename;
$imageFileType = pathinfo($location, PATHINFO_EXTENSION);

$valid_extensions = array("jpg", "jpeg", "png");
if (!in_array(strtolower($imageFileType), $valid_extensions)) {
   echo 0;
   die();
}

if (file_exists($location)) {
    echo 1;
    die();
}

if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
    echo $location;
} else {
    echo 2;
}