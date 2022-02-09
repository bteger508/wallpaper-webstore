<?php

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
        echo "Login successful";

        header('Location: ../landing-page');
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