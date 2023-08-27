<?php
require_once './db/configDB.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = 'DELETE FROM `readers` WHERE `id` = ?';
    $query = $pdo->prepare($sql);
    $query->execute([$id]);
    
    header('Location: ./readers/readers.php');
    exit();
}

?>