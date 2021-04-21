<?php

/**
 * MySQLとの接続をする
 * @param null
 * @return object $pdo
 */
function db_connect()
{
    $host = 'mysql5.7';
    $db = 'cart_db';
    $user = 'test';
    $pass = 'test';

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    try{
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    }catch(PDOException $e){
        echo 'error'. $e->getMessage();
    }
}

?>