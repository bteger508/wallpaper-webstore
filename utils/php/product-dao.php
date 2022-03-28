<?php

// Code for handling MySQL errors taken from 
// https://codereview.stackexchange.com/questions/174003/mysqli-query-and-error-handling-for-select-insert-and-update

if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../../');
}
include_once ROOT_DIR . './config/secrets.php';

var_dump(get_by_tagname('morning'));
set_error_handler("myErrorHandler");

function get_by_tagname($tag)
{
    $conn = DB_connect();
    var_dump($conn);
    echo "<br>";
    $stmt = $conn->prepare("SELECT p.price, p.description, p.path, t.name FROM product AS p 
                                INNER JOIN product_has_tag AS pht ON p.product_id=pht.product_id
                                INNER JOIN tag AS t ON pht.tag_id=t.tag_id
                                WHERE t.name=?
                                ORDER BY p.product_id");
    $stmt->bind_param('s', $tag);
    $result = $stmt->execute();

    $result = $stmt->get_result();
    $products = $result->fetch_assoc();
    return $products;
    $conn->close();
}

function DB_connect()
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    return $conn;
}

// The first parameter is required, even though it isn't used in the function body!
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    error_log("$errstr in $errfile:$errline");
    header('HTTP/1.1 500 Internal Server Error', True, 500);
    readfile(ROOT_DIR . "./utils/php/error.html");
    exit;
}
