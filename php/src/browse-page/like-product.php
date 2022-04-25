<?php
if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../');
}

include_once(ROOT_DIR . './utils/php/cookies.php');
include_once(ROOT_DIR . './utils/php/dao.php');
include_once(ROOT_DIR . './utils/php/product-dao.php');

// If the user is logged in, get the user's id
if (isset(getUserCookieData()['user_id'])) {
    $user_id = getUserCookieData()['user_id'];
} else {
    $user_id = null;
}

// Take a GET request and set productsArray to the products
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // If product_id is set, set it
    if (isset($_GET['product_id'])) {
        $product_id = strval($_GET['product_id']);
    } else {
        $product_id = null;
    }
}

// Like the product
if (isset($product_id) && isset($user_id)) {
    if (like_product($user_id, $product_id)) {
        header('Location: ../browse-page');
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
