<?php
$host = 'localhost';
$user = 'root';
$dbname = 'elite_pay';
$db_pass = '';

try {
    $dsn = 'mysql:host='.$host.';dbname='.$dbname;

$pdo = new PDO($dsn,$user,$db_pass);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo-> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
} catch (PDOException $e) {
   die('connection failed:'.$e->getMessage());
}


?>