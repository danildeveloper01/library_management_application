<?php
require_once '../db/configDB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];
    $new_title = $_POST['new_title'];
    $new_author = $_POST['new_author'];

    $updateQuery = "UPDATE `books` SET `title` = ?, `author` = ? WHERE `id` = ?";
    $updateStmt = $pdo->prepare($updateQuery);
    if ($updateStmt->execute([$new_title, $new_author, $book_id])) {
        header("Location: books.php");
        exit();
    } else {
        echo "Error: " . $updateStmt->errorInfo()[2];
    }
}