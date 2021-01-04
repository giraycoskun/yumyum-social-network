<?php

    $host = 'database-cs306.ckgnhb2bj9yb.us-east-2.rds.amazonaws.com';
    $user = 'admin';
    $pass = 'cs306database';
    $db_name = 'cs306_db';

    $conn = new mysqli($host, $user, $pass, $db_name);
    if($conn->connect_error){
        die('Connection Error'.$conn->connect_error);
    } 

    include 'db_test.php';
    $users = $conn->query("select * from Users");
    $result = $users->fetch_all();
    print_r($result);

    $conn->close();
?>