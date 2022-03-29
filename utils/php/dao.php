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
                                    favorite_color, phone_number, shopping_cart_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $current_date = new DateTime();
        $create_time = $current_date->format('Y-m-d');
        var_dump($create_time);

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

        return $stmt->execute();
        $conn->close();
    }
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
