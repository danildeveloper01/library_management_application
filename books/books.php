<?php 
    $title = 'Books';

    include_once '../block/header.php';

    require_once '../db/configDB.php';
    
    $searchResults = [];

    /*The search functionality is written. Expose the block with the code
    
    if(isset($_GET['searchTitle']) && !empty($_GET['searchTitle'])){
        $searchTitle = $_GET['searchTitle'];

        if(is_numeric($searchTitle)) {
            $searchQuery = "SELECT * FROM `books` WHERE `title` = ?";
            $stmt = $pdo->prepare($searchQuery);
            $stmt->execute([$searchTitle]);
            $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $searchQuery = "SELECT * FROM `books` WHERE `title` LIKE ? OR `title` LIKE ?";
            $searchTitlePattern = '%' . $searchTitle . '%';
            $stmt = $pdo->prepare($searchQuery);
            $stmt->execute([$searchTitlePattern, $searchTitlePattern]);
            $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }*/
?>
    <div class="container">
       <?php
            include_once '../block/link.php';
       ?>
        <h1>New book</h1>
        <form action="newbook.php" method="post" class="mt-4">
            <input type="text" name="title" id="title" class="form-control mt-3" placeholder="Title" required>
            <input type="text" name="author" id="author" class="form-control mt-3" placeholder="Author" required>
            <button type="submit" class="btn btn-success mt-4">Retain the book</button>
        </form>

        <!-- The search functionality is written. Expose the block with the code
            
        <h1 class="mt-4 mb-4">Search</h1>
        <form action="" method="get" class="mt-4">
            <input type="text" name="searchTitle" class="form-control" placeholder="Search by title">
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </form>    

        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center mt-4">
            <?php 
                /*foreach ($searchResults as $result) {
                    echo '<div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm">
                                <div class="card-body">';
                    echo '<ul class="list-unstyled mt-3 mb-4">';
                    echo '<h4 class="my-0 fw-normal">' . $result['title'] .  '</h4>';
                    echo '<li>' . $result['author'] . '</li>';

                    echo '<a href="deleteBooks.php?id='.$row->id.'">Delete</a>';
                    echo '</ul>';
                    echo '</div>
                            </div>
                        </div>';
                }*/
            ?>
        </div>    -->
        <h1 class="mt-4 mb-4">Books</h1>  
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">           
            <?php             
                $booksQuery = $pdo->query('SELECT * FROM `books` ORDER BY `author` ASC');
                $borrowedBooksQuery = $pdo->query('SELECT * FROM `borrowed_books`');
                
                $borrowedBooksData = $borrowedBooksQuery->fetchAll(PDO::FETCH_OBJ);

                while ($bookRow = $booksQuery->fetch(PDO::FETCH_OBJ)) {
                    echo '<div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm">
                                <div class="card-body">';                                        
                                    echo '<ul class="list-unstyled mt-3 mb-4">';
                                    echo '<h4 class="my-0 fw-normal mb-4">' . $bookRow->title . '</h4>';
                                    echo '<li class="mt-2"><b>Author:</b> ' . $bookRow->author . '</li>';
                                    echo '<li class="mt-2"><b>ID book number:</b> ' . $bookRow->id . '</li>';
                                    
                                    // Вывод информации из таблицы borrowed_books
                                    foreach ($borrowedBooksData as $borrowedBook) {
                                        if ($borrowedBook->book_id == $bookRow->id) {
                                            echo '<li class="mt-2 mb-3"><b>Status:</b> ' . $borrowedBook->status . '</li>';
                                            break;
                                        }
                                    }
                                    
                                    // redaction form
                                    echo '<form action="editBook.php" method="post">';
                                    echo '<input type="hidden" name="book_id" value="' . $bookRow->id . '">';
                                    echo '<input type="text" name="new_title" id="new_title" class="form-control" placeholder="Redaction title" required>';
                                    echo '<input type="text" name="new_author" id="new_author" class="form-control mt-2" placeholder="Redaction authot" required><br>';
                                    echo '<button type="submit" class="btn btn-success w-50 mb-4">Edit</button>';
                                    echo '</form>';
                                    
                                    echo '<a href="./deleteBooks.php?id='.$bookRow->id.'">Delete</a>';
                                    echo '</div>
                                </div>
                            </div>';
                }
            ?> 
        </div>
    </div>
    

</body>
</html>