<?php

$is_localhost = in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']) || $_SERVER['SERVER_NAME'] == 'localhost';

$dbname = 'dbstorage24360859922'; 

if ($is_localhost) {
    $host = 'localhost';
    $username = 'root'; 
    $password = '';    
} else {
    $host = 'localhost';
    $username = 'dbusr24360859922';
    $password = 'SxH5hSixGy8h';
}

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>