<?php
session_start();
/**
 * User: Andrew Maris
 * Semperstack.com
 */
$host = 'localhost';
$user = 'root';
$password = '';
$database ='cart';
try {
    if($db = new PDO('mysql:host='.$host.';dbname='.$database.';charset=utf8mb4', $user,$password)) {
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
} catch(PDOException $e) {
    var_dump($e->getMessage().$e->getLine().$e->getCode());
}