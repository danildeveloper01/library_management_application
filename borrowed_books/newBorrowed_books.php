<?php

require_once '../db/configDB.php';


/* 
    Table structure

    name table: borrowed_books;
    table:          
    #	Name	        Type	        Collation	           	Null	Default	  	            Extra	
    -----------------------------------------------------------------------------------------------------------
	1	id  	        int			                             No	    None		            AUTO_INCREMENT		
	2	status	        varchar(50)	    utf8mb4_general_ci		 No	    None			
	3	reader_id	    varchar(11)	    utf8mb4_general_ci		 No	    None				
	4   book_id	        int		                                 No 	None	
    5   defects         text            utf8mb4_general_ci       Yes	NULL
    6	borrowed_date   datetime                                 No     CURRENT_TIMESTAMP		DEFAULT_GENERATED	        	

*/






$status = $_POST['status'];
$reader_id = $_POST['idCard'];
$book_id = $_POST['idBook'];
$defects = $_POST['notes'];


if (mb_strlen($reader_id) > 11 || mb_strlen($reader_id) < 6 ) {
    echo "Error ID CARD NUMBER! Max - 11 , min - 6";
    exit();
} else if (mb_strlen($book_id) > 11) {
    echo "Error ID BOOK NUMDER! Max - 11";
    exit();
} 

/* This code block is checking if a reader with the given reader_id exists in the `readers` table and
if a book with the given book_id exists in the `books` table. */

$idToCheck = $reader_id;
$checkQuery = "SELECT COUNT(*) FROM `readers` WHERE `id` = ?";
$stmt = $pdo->prepare($checkQuery);
$stmt->execute([$idToCheck]);
$count = $stmt->fetchColumn();
if ($count == 0) {    
    echo "Such a reader does not exist." . '<br>';
    exit();
}

$idToCheck = $book_id; 
$checkQuery = "SELECT COUNT(*) FROM `books` WHERE `id` = ?";
$stmt = $pdo->prepare($checkQuery);
$stmt->execute([$idToCheck]);
$count = $stmt->fetchColumn();
if ($count == 0) {    
    echo "Such a book does not exist." . '<br>'; 
    exit(); 
}

/* This code block is checking if a book with the given book_id is already being issued. It does this
by executing a SELECT query on the `borrowed_books` table, filtering by the book_id and status
'Issuing'. If the count of rows returned is greater than 0, it means the book is already being
issued and the code displays the message "This book has already been issued." and exits the script. */

if ($status === 'issuing') {
    $checkQuery = "SELECT COUNT(*) FROM `borrowed_books` WHERE `book_id` = ? AND `status` = 'Issuing'";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute([$book_id]);
    $count = $checkStmt->fetchColumn();
    
    if ($count > 0) {
        echo "This book has already been issued.";
        exit();
    }
}

/* This code block is responsible for handling the logic when the status is set to 'returning' or any
other value. */

if ($status === 'returning') {
    $updateQuery = "UPDATE `borrowed_books` SET `status` = 'returning', `borrowed_date` = NOW() WHERE `book_id` = ? AND `reader_id` = ? AND `status` = 'Issuing'";
    $updateStmt = $pdo->prepare($updateQuery);
    if ($updateStmt->execute([$book_id, $reader_id])) {
        header("Location: borrowed_books.php");
        exit();
    } else {
        echo "Error: " . $updateStmt->errorInfo()[2];
        exit();
    }
} else {
    $query = "INSERT INTO `borrowed_books` (`status`, `reader_id`, `book_id`, `defects`, `borrowed_date`) VALUES (?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($query);
    if ($stmt->execute([$status, $reader_id, $book_id, $defects])) {
        header("Location: borrowed_books.php");
        exit();
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
        exit();
    }
}

$query = "INSERT INTO `borrowed_books` (`status`, `reader_id`, `book_id`, `defects`) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($query);
if ($stmt->execute([$status, $reader_id, $book_id, $defects])) {
    header("Location: borrowed_books.php");
    exit();
} else {
    echo "Error: " . $stmt->errorInfo()[2];
}
