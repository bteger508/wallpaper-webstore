<?php

include '../../config/secrets.php';

insert_user(null, 'bteger', 'bteger@bsu.edu', '222222', null, 'ben', 'eger', '2000-01-22', '#FFFFF', '111-111-1111', null);


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

    $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    $pw_hash = password_hash($password, PASSWORD_DEFAULT);

    // Check connection
    if ($conn->connect_error) {
        echo "Could not connect to mysql: {$conn->connect_error}";
    } else {
        $stmt = $conn->prepare("INSERT INTO user (user_id, username, email, password, create_time, first_name, last_name, date_of_birth, 
                                favorite_color, phone_number, shopping_cart_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
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
        $stmt->execute();
        printf("%d row inserted.\n", $stmt->affected_rows);
        $conn->close();
    }
}