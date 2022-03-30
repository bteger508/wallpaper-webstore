<?php

if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../');
}
include ROOT_DIR . './utils/php/dao.php';

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = getIfSet('username');
    $first_name = getIfSet('fname');
    $last_name = getIfSet('lname');
    $email = getIfSet('email');
    $password = getIfSet('password');
    $pw_confirm = getIfSet('pwConfirm');
    $phone = getIfSet('phone');
    $dob = getIfSet('dob');
    $favColor = getIfSet('favColor');
    $serviceAgreement = getIfSet('serviceAgreement');

    // Check that vars are not empty
    if (empty($username)) {
        $errors[] = "'username' cannot be empty";
    }
    if (empty($first_name)) {
        $errors[] = "'fname' cannot be empty";
    }
    if (empty($last_name)) {
        $errors[] = "'lname' cannot be empty";
    }
    if (empty($email)) {
        $errors[] = "'email' cannot be empty";
    }
    if (empty($password)) {
        $errors[] = "'password' cannot be empty";
    }
    if (empty($pw_confirm)) {
        $errors[] = "'pwConfirm' cannot be empty";
    }
    if (empty($phone)) {
        $errors[] = "'phone' cannot be empty";
    }
    if (empty($dob)) {
        $errors[] = "'dob' cannot be empty";
    }
    if (empty($favColor)) {
        $errors[] = "'favColor' cannot be empty";
    }
    if (empty($serviceAgreement)) {
        $errors[] = "'serviceAgreement' cannot be empty";
    }

    // Password validation
    if ($password != $pw_confirm) {
        $errors[] = "'password' must match 'pwConfirm'";
    }
    if (strlen($password) < 12) {
        $errors[] = "'password' must be at least 12 characters";
    }

    if (!contains2Numbers($password)) {
        $errors[] = "'password' must contain at least 2 numbers";
    }

    if (!check_special_chars($password)) {
        $errors[] = "'password' must contain at least 2 special chars";
    }

    if (!check_username($username)) {
        $errors[] = "'username' must contain at least 8 characters and consist only of letters and numbers";
    }

    // Do the actual request if no errors
    if (empty($errors)) {
        if (insert_user($username, $email, $password, $first_name, $last_name, $dob, $favColor, $phone, null)) {

            // get the user data and store it as a cookie
            $userDataResponse = validate_user($username, $password);
            $userDataJson = json_encode($userDataResponse);
            setcookie('wallpaperWebstoreCS420_userData', $userDataJson, time() + (86400 * 30), "/");
            // setcookie('userData', $userDataJson, 0, "/");
            header('Location: ../landing-page/index.php');
        } else {
            header('Location: ../register-page/index.php');
            $errors[] = 'Username already exists.';
        }
    }

    // echo the errors (if any)
    foreach ($errors as $error) {
        echo $error . '<br>';
    }
}

function contains2Numbers($pw)
{
    $contains_nums = '/.*(\d).*(\d)/';
    return preg_match($contains_nums, $pw);
}

function check_username($username)
{
    $valid = '/([a-zA-Z0-9]){8,}/';
    return preg_match($valid, $username);
}

function check_special_chars($pw)
{
    $reSpecial = '/([!@#$%^&*()_+\-=\[\]{};:\\|,.<>\/?])/';
    return preg_match_all($reSpecial, $pw) >= 2;
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getIfSet($name)
{
    if (isset($_POST[$name])) {
        return $_POST[$name];
    } else {
        return '';
    }
}
