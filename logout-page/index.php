<?php
if (!defined('ROOT_DIR')) {
	DEFINE('ROOT_DIR', __DIR__.'/../');
}
include_once ROOT_DIR . './utils/php/cookies.php';

// sets wallpaperWebstoreCS420_userData cookie to expire now
clearUserCookieData();

header('Location: ../landing-page/index.php');
?>