<?php

include '../../config/secrets.php';

$conn = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

// Check connection
if ($conn === false) {
    echo "Could not connect to mysql." . "<br>";
} else {
    echo "Connected" . "<br>";
}

mysqli_close($conn);