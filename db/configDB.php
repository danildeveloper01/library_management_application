<?php


/* The code is establishing a connection to a MySQL database using PDO (PHP Data Objects). */

$dsn = 'mysql:host=localhost;dbname=library';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}


