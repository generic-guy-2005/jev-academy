<?php
    $host = "localhost";
    $user = "root";
    $password = "282005";
    $db = "project-jev-glossarium";

    $connection = new mysqli($host, $user, $password, $db);

    if($connection -> connect_error){
        echo "Connection Timed Out: " . $connection -> connect_error;
        exit;
    } else {
        echo "Connection Established";
    }
?>