<?php
if (!defined('ROOT_DIR')) {
	DEFINE('ROOT_DIR', __DIR__.'/../');
}
include ROOT_DIR.'./utils/php/dao.php';

$picture_title = $_POST['pictureTitle'];
$picture_price = $_POST['picturePrice'];
$picture_description = $_POST['pictureDescription'];
$picture_image_name = $_FILES['pictureImage']['name'];
$tags = $_POST['tags'];

$random_upload_name = bin2hex(random_bytes(10)) . '.jpeg';
$picture_path = ROOT_DIR . './resources/upload/' . $random_upload_name;

$product_id = product_insert($picture_title, strval($picture_price), $random_upload_name ,$picture_title, $picture_description);

// File upload
if ((($_FILES['pictureImage']["type"] == "image/jpeg"))
&& ($_FILES['pictureImage']["size"] < 2000000))
  {
  if ($_FILES['pictureImage']["error"] > 0)
    {
    echo "Return Code: " . $_FILES['pictureImage']["error"] . "<br />";
    }
  else
    {
    // echo "Upload: " . $_FILES['pictureImage']["name"] . "<br />";
    // echo "Type: " . $_FILES['pictureImage']["type"] . "<br />";
    // echo "Size: " . ($_FILES['pictureImage']["size"] / 1024) . " Kb<br />";
    // echo "Temp file: " . $_FILES['pictureImage']["tmp_name"] . "<br />";

    if (file_exists($picture_path))
      {
      echo $_FILES['pictureImage']["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES['pictureImage']["tmp_name"], $picture_path);
    //   echo "Stored in: " . $picture_path;
      }
    }
  }
else
  {
  echo "Invalid image file";
  }

// add tags to the product
foreach ($tags as $tag_str)
{
    add_tag_to_product($product_id, strval($tag_str));
}

?>