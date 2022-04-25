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
        $items = array();
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }
    return array();
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

// get products by user likes
function get_products_by_user_likes($user_id)
{
    $conn = DB_connect();
    $stmt = $conn->prepare("SELECT p.price, p.description, p.path, p.product_id 
            FROM product AS p 
            INNER JOIN user_likes_product AS ulp 
            ON p.product_id=ulp.product_id 
            WHERE ulp.user_id=? 
            ORDER BY p.product_id");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $conn->close();
}

// get all ids for products that the user liked
function get_liked_products_by_user_id($user_id)
{
    $conn = DB_connect();
    $stmt = $conn->prepare("SELECT * FROM user_likes_product WHERE user_id=?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $result;
}

// like a product
function like_product($user_id, $product_id)
{
    $conn = DB_connect();
    $stmt = $conn->prepare("INSERT INTO user_likes_product (user_id, product_id) VALUES (?, ?)");
    $stmt->bind_param('ii', $user_id, $product_id);
    $stmt->execute();
    $conn->close();
}

// unlike a product
function unlike_product($user_id, $product_id)
{
    $conn = DB_connect();
    $stmt = $conn->prepare("DELETE FROM user_likes_product WHERE user_id=? AND product_id=?");
    $stmt->bind_param('ii', $user_id, $product_id);
    $stmt->execute();
    $conn->close();
}

// check if product id is in liked_product array
function is_product_liked($liked_products, $product_id)
{
    foreach ($liked_products as $liked_product) {
        if ($liked_product['product_id'] == $product_id) {
            return true;
        }
    }
    return false;
}

// get total likes for a product
function get_total_likes_by_product_id($product_id)
{
    $conn = DB_connect();
    $stmt = $conn->prepare("SELECT COUNT(*) AS total_likes FROM user_likes_product WHERE product_id=?");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $conn->close();
    return $result['total_likes'];
}

// add comment to a product
function add_comment($user_id, $product_id, $comment_text)
{
    $conn = DB_connect();
    $conn->autocommit(false);
    $stmt1 = $conn->prepare("INSERT INTO comment (text, create_time) VALUES (?, NOW())");
    $stmt1->bind_param('s', $comment_text);
    $stmt1->execute();

    // get comment id from last insert
    $comment_id = $conn->insert_id;

    $stmt3 = $conn->prepare("INSERT INTO user_has_comment (user_id, comment_id) VALUES (?, ?)");
    $stmt3->bind_param('ii', $user_id, $comment_id);

    $stmt4 = $conn->prepare("INSERT INTO product_has_comment (product_id, comment_id) VALUES (?, ?)");
    $stmt4->bind_param('ii', $product_id, $comment_id);

    $stmt3->execute();
    $stmt4->execute();

    $conn->commit();

    $conn->autocommit(true);

    $conn->close();

    return true;
    
    // $stmt = $conn->prepare("INSERT INTO comment (text, create_time) 
    //                         VALUES (?, NOW());
    //                         SELECT @comment_id := LAST_INSERT_ID();
    //                         INSERT INTO user_has_comment (user_id, comment_id)
    //                         VALUES (?, @comment_id);
    //                         INSERT INTO product_has_comment (product_id, comment_id)
    //                         VALUES (?, @comment_id);");
    // $stmt->bind_param('sii', $comment_text, $user_id, $product_id);
    // $stmt->execute();
    // $conn->close();
}

// get comments for a product
function get_comments_by_product_id($product_id)
{
    $conn = DB_connect();
    $stmt = $conn->prepare("SELECT c.text, c.create_time, uc.user_id
                            FROM comment AS c 
                            INNER JOIN user_has_comment AS uc ON c.comment_id=uc.comment_id
                            INNER JOIN product_has_comment AS pc ON c.comment_id=pc.comment_id
                            WHERE pc.product_id=?
                            ORDER BY c.create_time DESC");
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $conn->close();
}
