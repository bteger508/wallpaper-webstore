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
    $stmt = $conn->prepare("SELECT p.price, p.description, p.path, t.name FROM product AS p 
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
