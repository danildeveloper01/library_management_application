<?php
require_once '../db/configDB.php';

/* 
    Table structure

    name table: books;
    table:          
    #	Name	Type	        Collation	           	Null	Default	  	Extra	
	1	id  	int			                             No	    None		AUTO_INCREMENT		
	2	title	varchar(50)	    utf8mb4_general_ci		 No	    None			
	3	author	varchar(100)	utf8mb4_general_ci		 No	    None				
	4	taken	tinyint(1)		                         Yes	NULL			        	

*/
/* The code is using regular expressions to remove any digits from the `['title']` and
`['author']` values. Then, it uses the `ucwords()` function to capitalize the first letter of
each word in the resulting string. This is done to ensure that the title and author names are
properly formatted before being used in the database query. */
$title = ucwords(preg_replace('/\d/', '', $_POST['title']));
$author = ucwords(preg_replace('/\d/', '', $_POST['author']));



/* The code block is checking the length of the `` and `` variables. If the length of
`` is greater than 50 characters or less than 2 characters, or if the length of `` is
greater than 100 characters or less than 2 characters, it will display an error message and exit the
script. This ensures that the title and author values meet the required length constraints before
proceeding with the database query. */

if (mb_strlen($title) > 50 || mb_strlen($title) <2 ) {
    echo "Error TITLE! Max - 50, min - 2";
    exit();
} else if (mb_strlen($author) > 100 || mb_strlen($author) < 2) {
    echo "Error AUTHOR! Max - 100, min - 2";
    exit();
} 

/* The code block you mentioned is checking if a book with the same title already exists in the
database. */

$titleToCheck = $_POST['title'];
$checkQuery = "SELECT COUNT(*) FROM `books` WHERE `title` = ?";
$stmt = $pdo->prepare($checkQuery);
$stmt->execute([$titleToCheck]);
$count = $stmt->fetchColumn();
if ($count > 0) {    
    echo "Such a reader already exists.".'<br>';
}

$query = "INSERT INTO `books` (`title`, `author`) VALUES (?, ?)";
$stmt = $pdo->prepare($query);
if ($stmt->execute([$title, $author])) {
    header("Location: ../added.php");
    exit();
} else {
    echo "Error: " . $stmt->errorInfo()[2];
}