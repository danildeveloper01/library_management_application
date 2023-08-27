<?php
require_once '../db/configDB.php';

/* This code is checking if the `id` parameter is set in the URL query string. If it is set, it
retrieves the value of `id` and uses it to delete a record from the `books` table in the database.
After deleting the record, it redirects the user to the `books.php` page. The `exit()` function is
used to stop the execution of the script after the redirect. */

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = 'DELETE FROM `books` WHERE `id` = ?';
    $query = $pdo->prepare($sql);
    $query->execute([$id]);
    
    header('Location: books.php');
    exit();
}

?>