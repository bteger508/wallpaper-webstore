<?php

include '../../config/secrets.php';

insert_user();

function insert_user()
{
    $conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    // Check connection
    if ($conn === false) {
        echo "Could not connect to mysql." . "<br>";
    } else {
        echo "Connected" . "<br>";
    }

    $sql = $conn->prepare("insert into user
        (user_id, username, email, password, create_time, first_name, last_name, date_of_birth, favorite_color, phone_number, shopping_cart_id) values
        (null, 'bteger', 'bteger@bsu.edu', '111111', null, 'ben', 'eger', '2000-01-22', '#FFFFF', '111-111-1111', null)");
    $sql->execute();
    $sql->close();
    $conn->close();
}