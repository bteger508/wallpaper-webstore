<?php
if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../');
}
include_once ROOT_DIR . './utils/php/dao.php';
include_once ROOT_DIR . './utils/php/product-dao.php';
include_once ROOT_DIR . './utils/php/cookies.php';

// Check if get request
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // If the user is logged in, get the user's id
    if (isset(getUserCookieData()['user_id'])) {
        $user_id = getUserCookieData()['user_id'];
    } else {
        $user_id = null;
    }

    // If the userId is set, get the products in the user's cart
    if (isset($user_id)) {
        remove_all_products_from_cart($user_id);
        header('Location: ../cart-page/index.php');
    } else {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

}