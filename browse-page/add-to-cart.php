<?php
if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../');
}
include_once (ROOT_DIR . './utils/php/cookies.php');
include_once (ROOT_DIR . './utils/php/dao.php');
include_once (ROOT_DIR . './utils/php/product-dao.php');

include_once(ROOT_DIR . './utils/php/cookies.php');
include_once(ROOT_DIR . './utils/php/dao.php');
// get the get request
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // If product_id is set, set it
    if (isset($_GET['product_id'])) {
        $product_id = strval($_GET['product_id']);
        // get product tags
        $tags = get_tags_by_product_id($product_id);
        $tagNames = array();
        foreach ($tags as $tag) {
            array_push($tagNames, $tag['name']);
        }
        incrementTagScores($tagNames, 6);
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

if (isset($product_id) && isset($user_id)) {
    // If the user is logged in, add the product to their cart
    if (add_product_to_cart($user_id, $product_id)) {
        header('Location: ../cart-page');
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}

