<?php

    $host = 'database-cs306.ckgnhb2bj9yb.us-east-2.rds.amazonaws.com';
    $user = 'admin';
    $pass = 'cs306database';
    $db_name = 'cs306_db';

    $dsn = "mysql:host=$host;dbname=$db_name";

    try
    {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        #echo 'Hello Database';
    }
    catch(PDOException $e)
    {
        echo '<h1 class="text-danger">Error in Database Connection</h1>';
        #throw new PDOException($e->getMessage());
        
    }

    require_once 'crud.php';
    $crud = new crud($pdo);

?>