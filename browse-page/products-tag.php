<?php
if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../');
}
include_once ROOT_DIR . './utils/php/dao.php';
include_once ROOT_DIR . './utils/php/product-dao.php';

// Take a GET request and return all the products by tag
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $products = get_by_tagname($_GET['tag'], $_GET['limit']);
    echo json_encode($products);
}