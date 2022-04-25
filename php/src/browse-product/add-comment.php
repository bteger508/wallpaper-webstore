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

// Take a POST request and set productsArray to the products
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // If product_id is set, set it
    if (isset($_POST['product_id'])) {
        $product_id = strval($_POST['product_id']);
    } else {
        $product_id = null;
    }
}

// comment on the product
if (isset($product_id) && isset($user_id)) {
    // if comment is empty, redirect
    if (empty($_POST['comment'])) {
        header('Location: ../browse-product?product_id=' . $product_id);
    } else {
        // If the user is logged in, add the product to their cart
        if (add_comment($user_id, $product_id, $_POST['comment'])) {
            header('Location: ../browse-product?product_id=' . $product_id);
        } else {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}
