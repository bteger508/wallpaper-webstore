<?php

if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../');
}
include ROOT_DIR . './utils/php/dao.php';
session_start(); // start session to enable session vars
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = getIfSet('username');
    $password = getIfSet('password');


    // Check that vars are not empty
    if (empty($username)) {
        $errors[] = "'username' cannot be empty";
    }
    if (empty($password)) {
        $errors[] = "'password' cannot be empty";
    }

    // echo the errors (if any)
    foreach ($errors as $error) {
        echo $error . '<br>';
    }

    // Do the actual request if no errors
    if (empty($errors)) {
        $userDataResponse = validate_user($username, $password);
        $userJson = json_encode($userDataResponse);
        setcookie('userData', $userJson, 0, "/");
        if (!empty($userDataResponse)) {
            header('Location: ../landing-page');
        } else {
            header('Location: ../login-page');
        }
    }
}

function getIfSet($name)
{
    if (isset($_POST[$name])) {
        return $_POST[$name];
    } else {
        return '';
    }
}
