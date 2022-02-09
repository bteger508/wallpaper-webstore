<?php

$errors = [];
$username = $first_name = $last_name = $password = $pw_confirm = $phone = $email;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = test_input($_POST['username']);
    $first_name = test_input($_POST['fname']);
    $last_name = test_input($_POST['lname']);
    $password = test_input($_POST['password']);
    $pw_confirm = test_input($_POST['pwConfirm']);
    $phone = test_input($_POST['phone']);
    $email = test_input($_POST['email']);
    $errors = [];

    if ($username == "") {
        array_push($errors, "Username cannot be empty");
    }
    echo $first_name;
    echo $last_name;
    echo $password;
    echo $pw_confirm;
    echo $phone;
    echo $email;
}


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}