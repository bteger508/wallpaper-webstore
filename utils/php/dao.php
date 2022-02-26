<?php

include '../../config/secrets.php';


set_error_handler("myErrorHandler");

// functions for testing

// var_dump(insert_user(null, 'bteger', 'bteger@bsu.edu', '222222', null, 'ben', 'eger', '2000-01-22', '#FFFFF', '111-111-1111', null));
// var_dump(retrieve_all_users());

function DB_connect()
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    return $conn;
}



function retrieve_all_users()
{
    $conn = DB_connect();
    $result = $conn->query("SELECT * FROM user");
    if ($result) {
        return $result->fetch_assoc();
    }
    $conn->close();
}

function insert_user(
    $user_id,
    $username,
    $email,
    $password,
    $create_time,
    $first_name,
    $last_name,
    $date_of_birth,
    $favorite_color,
    $phone_number,
    $shopping_cart_id
) {

    $conn = DB_connect();
    $stmt = $conn->prepare("INSERT INTO user (user_id, username, email, password, create_time, first_name, last_name, date_of_birth, 
                                favorite_color, phone_number, shopping_cart_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $pw_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->bind_param(
        "isssssssssi",
        $user_id,
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

// The first parameter is required, even though it isn't used in the function body!
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    error_log("$errstr in $errfile:$errline");
    header('HTTP/1.1 500 Internal Server Error', True, 500);
    readfile("error.html");
    exit;
}