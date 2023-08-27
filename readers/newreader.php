<?php
require_once '../db/configDB.php';



/* 
    Table structure

    name table: borrowed_books;
    table:          
    #	Name	        Type	        Collation	           	Null	Default	  	            
    ------------------------------------------------------------------------------
	1	id  	        int			    utf8mb4_general_ci       No	    None		            
	2	name	        varchar(50)	    utf8mb4_general_ci		 No	    None			
	3	surname 	    varchar(100)	utf8mb4_general_ci		 No	    None				
	4   date	        date		                             No 	None	
    


    id =  ID Card Number

*/






$name = ucwords(preg_replace('/\d/', '', $_POST['name']));
$surname = ucwords(preg_replace('/\d/', '', $_POST['surname']));
$id = trim($_POST['idCard']);
$date = $_POST['date'];


if (mb_strlen($name) > 50 || mb_strlen($name) <2 ) {
    echo "Error NAME! Max - 50, min - 2";
    exit();
} else if (mb_strlen($surname) > 100 || mb_strlen($surname) < 2) {
    echo "Error SURNAME! Max - 100, min - 2";
    exit();
} else if (mb_strlen($id) > 11 || mb_strlen($id) < 6) {
    echo "Error ID CARD NUMBER! Max - 11, min - 6";
    exit();
}

/* The code block you provided is checking if a reader with the same ID card number already exists in
the `readers` table. */

$idToCheck = $_POST['idCard'];
$checkQuery = "SELECT COUNT(*) FROM `readers` WHERE `id` = ?";
$stmt = $pdo->prepare($checkQuery);
$stmt->execute([$idToCheck]);
$count = $stmt->fetchColumn();
if ($count > 0) {    
    echo "Such a reader already exists.".'<br>';
}

$query = "INSERT INTO `readers` (`name`, `surname`, `id`, `date`) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($query);
if ($stmt->execute([$name, $surname, $id, $date])) {
    header("Location: ../added.php");
    exit();
} else {
    echo "Error: " . $stmt->errorInfo()[2];
}





