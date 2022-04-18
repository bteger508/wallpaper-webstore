<?php

// Code for handling MySQL errors taken from 
// https://codereview.stackexchange.com/questions/174003/mysqli-query-and-error-handling-for-select-insert-and-update

if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../../');
}
include_once ROOT_DIR . './config/secrets.php';
include_once ROOT_DIR . './utils/php/dao.php';

// var_dump(get_by_tagname('morning', 3));
set_error_handler("myErrorHandler");

function get_by_tagname($tag = 'scenary', $limit = 3)
{

    if (empty($tag))
        $tag = 'scenary';

    $conn = DB_connect();
    $stmt = $conn->prepare("SELECT p.price, p.description, p.path, t.name, p.product_id FROM product AS p 
                                INNER JOIN product_has_tag AS pht ON p.product_id=pht.product_id
                                INNER JOIN tag AS t ON pht.tag_id=t.tag_id
                                WHERE t.name=?
                                ORDER BY p.product_id
                                LIMIT ?");
    $stmt->bind_param('si', $tag, $limit);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $conn->close();
}

// get all products in the db
function get_all_products()
{
    $conn = DB_connect();
    $result = $conn->query("SELECT * FROM product");

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }
    $conn->close();
}

// get all tags for a product
function get_tags_by_product_id($product_id)
{
    $conn = DB_connect();
    $stmt = $conn->prepare("SELECT t.name FROM product_has_tag AS pht 
                                INNER JOIN tag AS t ON pht.tag_id=t.tag_id
                                WHERE pht.product_id=?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}
