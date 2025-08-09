<?php

try {
    $dsn = "mysql:host=localhost;dbname=dbContactList";
    $username = "root";
    $password = "";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];
    
    $conn = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo $e->getMessage();
}