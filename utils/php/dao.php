<?php

// Code for handling MySQL errors taken from 
// https://codereview.stackexchange.com/questions/174003/mysqli-query-and-error-handling-for-select-insert-and-update


if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../../');
}

include_once ROOT_DIR . './config/secrets.php';

set_error_handler("myErrorHandler");
// var_dump(validate_user("coolguycool", "Be182020!@Be"));
// functions for testing
// var_dump(username_exists("wamie")); 
// var_dump(insert_user('wamie4', 'bteger@bsu.edu', '12345', 'ben', 'eger', '2000-01-22', '#FFFFF', '111-111-1111', null));
// var_dump(retrieve_all_users());
// var_dump(validate_user("wamie", '12345'));
// product_insert("it's it's this\" LOOK", 0.25, "/uploads/picture", "yup picture", "this is really cool!");


// Returns true if the $username and pw match a record in the db, else false
function validate_user($username, $password)
{
    $conn = DB_connect();
    $stmt = $conn->prepare("SELECT * FROM user WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $userData = $stmt->get_result()->fetch_assoc();
    if (password_verify($password, $userData['password'])) {
        return $userData;
    } else
        return null;
    $conn->close();
}

// Returns an associative array of all user records in the DB
function retrieve_all_users()
{
    $conn = DB_connect();
    $result = $conn->query("SELECT * FROM user");

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }
    $conn->close();
}

// Inserts a user into MySQL if the username is not taken! Returns true if insertion succeeds, otherwise false.
function insert_user(
    $username,
    $email,
    $password,
    $first_name,
    $last_name,
    $date_of_birth,
    $favorite_color,
    $phone_number,
    $shopping_cart_id
) {

    // Don't allow duplicate usernames
    if (username_exists($username)) {
        return False;
    } else {
        $conn = DB_connect();
        $stmt = $conn->prepare("INSERT INTO user (username, email, password, create_time, first_name, last_name, date_of_birth, 
                                    favorite_color, phone_number, shopping_cart_id, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
        $current_date = new DateTime();
        $create_time = $current_date->format('Y-m-d');

        $pw_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param(
            "sssssssssi",
            $username,
            $email,
            $pw_hash,
            $create_time,
            $first_name,
            $last_name,
            $date_of_birth,
            $favorite_color,
            $phone_number,
            $shopping_cart_id
        );

        $result = $stmt->execute();
    
        // get the id of the user that was just inserted
        $user_id = $conn->insert_id;

        // insert a cart for the user based on the user_id
        insert_shopping_cart($user_id);

        $conn->close();
        return $result;
    }
}

// Create a shopping cart for a user
function insert_shopping_cart($user_id)
{
    $conn = DB_connect();
    $stmt = $conn->prepare("INSERT INTO shopping_cart () VALUES ()");
    $stmt->execute();
    $cart_id = $conn->insert_id;

    // update the user's shopping cart id
    $stmt = $conn->prepare("UPDATE user SET shopping_cart_id=? WHERE user_id=?");
    $stmt->bind_param("ii", $cart_id, $user_id);
    $stmt->execute();
    
    $conn->close();
    return $cart_id;
}

// Add a product to the shopping cart
function add_product_to_cart($user_id, $product_id)
{
    $conn = DB_connect();

    // get the cart id for the user
    $stmt = $conn->prepare("SELECT shopping_cart_id FROM user WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_id = $stmt->get_result()->fetch_assoc()['shopping_cart_id'];

    // check if the product is already in the cart
    $stmt = $conn->prepare("SELECT * FROM shopping_cart_has_product WHERE shopping_cart_id=? AND product_id=?");
    $stmt->bind_param("ii", $cart_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    if ($result) return false;

    // insert the product into the cart
    $stmt = $conn->prepare("INSERT INTO shopping_cart_has_product (shopping_cart_id, product_id, quantity) VALUES (?, ?, 1)");
    $stmt->bind_param("ii", $cart_id, $product_id);
    $result = $stmt->execute();
    $conn->close();
    return true;
}

// Get all the products in the cart for the user
function get_products_in_cart_for_user($user_id)
{
    $conn = DB_connect();

    // get the cart id for the user
    $stmt = $conn->prepare("SELECT shopping_cart_id FROM user WHERE user_id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_id = $stmt->get_result()->fetch_assoc()['shopping_cart_id'];
    // return false if the cart id is null
    if (!$cart_id) return false;

    // get all rows in the cart
    $stmt = $conn->prepare("SELECT * FROM shopping_cart_has_product WHERE shopping_cart_id=?");
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $cartResult = $stmt->get_result();
    // return false if the cart is empty
    if ($cartResult->num_rows == 0) return false;

    // set the product ids to an array
    $product_ids = array();
    while ($row = $cartResult->fetch_assoc()) {
        $product_ids[] = $row['product_id'];
    }

    // get all the products in the cart
    $stmt = $conn->prepare("SELECT * FROM product WHERE product_id IN (" . implode(',', $product_ids) . ")");
    $stmt->execute();
    $productResult = $stmt->get_result();

    // set the products to an array
    $products = array();
    while ($row = $productResult->fetch_assoc()) {
        $products[] = $row;
    }

    $conn->close();
    return $products;
}

// Gets a product by id
function get_product_by_id($product_id)
{
    $conn = DB_connect();
    $stmt = $conn->prepare("SELECT * FROM product WHERE product_id=?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $conn->close();
    return $result;
}

// Returns true if $username already exists in MySQL
function username_exists($username)
{
    $conn = DB_connect();
    $stmt = $conn->prepare("SELECT user_id FROM user WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();

    return !is_null($user_id);
    $conn->close();
}

// Insert a new product into the Product table
function product_insert(
    $title,
    $price,
    $picturePath,
    $altText,
    $description
) {
    $conn = DB_connect();
    $stmt = $conn->prepare("INSERT INTO product 
                            (title, price, path, altText, description) VALUES 
                            (?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsss", $title, $price, $picturePath, $altText, $description);
    $stmt->execute();
    return $stmt->insert_id;
    // TODO: Add some return statement to know that the product was successfully inserted
}

// Adds a tag to a product id
function add_tag_to_product($productId, $tagId)
{
    $conn = DB_connect();
    $stmt = $conn->prepare("INSERT INTO product_has_tag 
                            (product_id, tag_id) VALUES 
                            (?, ?)");
    $stmt->bind_param("dd", $productId, $tagId);
    $stmt->execute();
}

function retrieve_all_tags()
{
    $conn = DB_connect();
    $result = $conn->query("SELECT * FROM tag");

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        return $items;
    }
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
