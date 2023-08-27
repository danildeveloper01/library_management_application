<?php
require_once '../db/configDB.php';

/* This code block is checking if the HTTP request method is POST. If it is, it retrieves the values of
`reader_id`, `new_name`, and `new_surname` from the POST data. */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reader_id = $_POST['reader_id'];
    $new_name = $_POST['new_name'];
    $new_surname = $_POST['new_surname'];
 
    
    $updateQuery = "UPDATE `readers` SET `name` = ?, `surname` = ? WHERE `id` = ?";
    $updateStmt = $pdo->prepare($updateQuery);
    if ($updateStmt->execute([$new_name, $new_surname, $reader_id])) {
        header("Location: readers.php");
        exit();
    } else {
        echo "Error: " . $updateStmt->errorInfo()[2];
    }
}

