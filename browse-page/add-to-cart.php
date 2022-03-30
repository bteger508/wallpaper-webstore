<?php
if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../');
}

include_once(ROOT_DIR . './utils/php/cookies.php');
include_once(ROOT_DIR . './utils/php/dao.php');
// get the get request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // If product_id is set, set it
    if (isset($_GET['product_id'])) {
        $product_id = strval($_GET['product_id']);
    } else {
        $product_id = null;
    }
    
    // If user_id is set, set it
    if (isset(getUserCookieData()['user_id'])) {
        $user_id = getUserCookieData()['user_id'];
    } else {
        $user_id = null;
    }
}

echo $product_id . '<br>';
echo $user_id . '<br>';
if (isset($product_id) && isset($user_id)) {
    // If the user is logged in, add the product to their cart
    if (add_product_to_cart($user_id, $product_id)) {
        echo '<div class="alert alert-success" role="alert">Product added to cart!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Product could not be added to cart!</div>';
    }
}

