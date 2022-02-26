<?php

include '../../config/secrets.php';

// $user1 = new user();
// $user1->set_userid(null);
// $user1->set_username('joe');
// $user1->set_email('jschmoe@bsu.edu');
// $user1->set_password('joeisaboss');
// $user1->set_password('joeisaboss');
// $user1->set_create_time('joeisaboss');
// $user1->set_create_time('joeisaboss');
insert_user('null', 'bteger', 'bteger@bsu.edu', '222222', 'null', 'ben', 'eger', '2000-01-22', '#FFFFF', '111-111-1111', 'null');


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
    // $conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    $conn = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    // Check connection
    if ($conn === false) {
        echo "Could not connect to mysql." . "<br>";
    } else {
        echo "Connected" . "<br>";
    }

    // $sql = "INSERT INTO user (user_id, username, email, password, create_time, first_name, last_name, date_of_birth, favorite_color, phone_number, shopping_cart_id) values
    // ({$user_id}, {$username}, {$email}, {$password}, {$create_time}, {$first_name}, {$last_name}, {$date_of_birth}, {$favorite_color}, {$phone_number}, {$shopping_cart_id})";
    $stmt = $conn->prepare("INSERT INTO user (user_id, username, email, password, create_time, first_name, last_name, date_of_birth, favorite_color, phone_number, shopping_cart_id) VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $user_id = null;
    $username = 'joe';
    $email = 'j';
    $password = 'pass';
    $created_time = null;
    $first_name = 'joe';
    $last_name = 'schmoe';
    $date_of_birth = '2000-01-01';
    $favorite_color = '#FFFFF';
    $phone_number = '111-111-1111';
    $shopping_cart_id = null;

    $stmt->bind_param("isssssssssi", $user_id, $username, $email, $password, $created_time, $first_name, $last_name, $date_of_birth, $favorite_color, $phone_number, $shopping_cart_id);
    $stmt->execute();
    printf("%d row inserted.\n", $stmt->affected_rows);
    $conn->close();

    // $sql = "INSERT INTO user (user_id, username, email, password, create_time, first_name, last_name, date_of_birth, favorite_color, phone_number, shopping_cart_id) values
    // (null, {$username}, {$email}, {$password}, null, {$first_name}, {$last_name}, {$date_of_birth}, {$favorite_color}, {$phone_number}, null)";

    // Perform the query
    // if ($result = mysqli_query($conn, $sql)) {
    //     echo "Success";
    //     mysqli_free_result($result);
    // } else {
    //     var_dump($sql);
    //     echo '<br><br>';
    //     var_dump($conn);
    // }
    // mysqli_close($conn);
}

// class user
// {
//     public $userid = 'null';
//     public $username = 'jschmoe';
//     public $email = 'jschmoe@bsu.edu';
//     public $password = 'joeisaboss';
//     public $create_time = 'null';
//     public $first_name = 'joe';
//     public $last_name = 'schmoe';
//     public $date_of_birth = '2000-01-22';
//     public $favorite_color = '#AAAAA';
//     public $phone_number = '222-222-2222';
//     public $shopping_cart_id = 'null';
// }