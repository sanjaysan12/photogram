<?php
include 'libs/load.php';
$upload_path = get_config('upload_path');
$fname = $_GET['name'];
print($fname);

$image_path = $upload_path . $fname;
$image_path = str_replace('..','',$image_path);
print($image_path);
if(is_file($image_path)){
    header("Content-type:".mime_content_type($image_path));
    header("Content-Length:".filesize($image_path));
    echo file_get_contents($image_path);
}

