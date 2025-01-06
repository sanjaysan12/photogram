
<?php
include 'libs/load.php';
print(Session::getUser()->getEmail());
$img_temp = $_FILES['post_image']['tmp_name'];
$text = $_POST['post_text'];
echo $img_temp;
Post::registerpost($text,$img_temp);
?>