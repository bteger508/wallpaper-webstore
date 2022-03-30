<?php
// sets wallpaperWebstoreCS420_userData cookie to expire now
setcookie('wallpaperWebstoreCS420_userData', '', time() - 3600, '/');

header('Location: ../landing-page/index.php');
?>