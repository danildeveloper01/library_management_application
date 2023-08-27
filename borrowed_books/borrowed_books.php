<?php 
    $title = 'Issuing or returning a book';

    include_once '../block/header.php';

    require_once '../db/configDB.php';
    
?>
    <div class="container">
       <?php
            include_once '../block/link.php';
       ?>

        <h1>Issuing or returning a book</h1>
        <form action="newBorrowed_books.php" method="post" class="mt-4">
            <label for="status">Issuing or returning a book?</label>
            <select name="status" id="status" class="form-control mt-3">
                <option value="issuing">Issuing</option>
                <option value="returning">Returning</option>
            </select>
            <input type="text" name="idCard" id="idCard" class="form-control mt-3" placeholder="ID card number" required>
            <input type="number" name="idBook" id="idBook" class="form-control mt-3" placeholder="ID book number" required>
            <textarea name="notes" id="notes" class="form-control mt-3" rows="4" placeholder="There's damage to the book, write it down? If not, leave the field blank " ></textarea>
            <button type="submit" class="btn btn-success mt-4">Write down</button>
        </form>
        <h1 class="mt-4 mb-4">History</h1>  
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">           
       <!-- The code block is querying the database to retrieve data from three tables:
        `borrowed_books`, `readers`, and `books`. -->
        <?php             
            $borrowedBooksQuery = $pdo->query('SELECT * FROM `borrowed_books` ORDER BY `borrowed_date` DESC');
            $readersQuery = $pdo->query('SELECT * FROM `readers`');
            $booksQuery = $pdo->query('SELECT * FROM `books`');
            
            $readersData = $readersQuery->fetchAll(PDO::FETCH_OBJ);
            $booksData = $booksQuery->fetchAll(PDO::FETCH_OBJ);
            
            while ($row = $borrowedBooksQuery->fetch(PDO::FETCH_OBJ)) {
                echo '<div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-body">';
                echo '<ul class="list-unstyled mt-3 mb-4">';
                echo '<h4 class="my-0 fw-normal">Status: ' . $row->status .  '</h4>';
                echo '<li class ="mt-5"><b>Regisrtation number:</b> ' . $row->id .  '</li>';
            
                foreach ($readersData as $readerRow) {
                    if ($readerRow->id == $row->reader_id) {
                        echo '<li class ="mt-2"><b>Name:</b> ' . $readerRow->name . ' ' . $readerRow->surname . '</li>';
                        echo '<li class ="mt-2"><b>ID card number:</b> ' . $readerRow->id . '</li>';
                        if (!empty($readerRow->date)) {
                            $formattedDate = date("d.m.Y", strtotime($readerRow->date));
                            echo '<li class ="mt-2"><b>Birthdate:</b> ' . $formattedDate . '</li>';
                        } else {
                            echo '<li class ="mt-2"><b>Birthdate: ERROR </b> </li>';
                        }
                        break;
                    }
                }
            
                foreach ($booksData as $bookRow) {
                    if ($bookRow->id == $row->book_id) {
                        echo '<li class ="mt-2"><b>Title book:</b> ' . $bookRow->title . '</li>';
                        echo '<li class ="mt-2"><b>Author book:</b> ' . $bookRow->author . '</li>';
                        echo '<li class ="mt-2"><b>ID book number:</b> ' . $bookRow->id . '</li>';
                        break;
                    }
                }
                echo '<li class="mt-2"><b>Defects:</b> ' . $row->defects . '</li>';
                echo '<li class="mt-2"><b>Date:</b> ' . $row->borrowed_date . '</li>';
                echo '</ul>';
                
                echo '</div>
                    </div>
                </div>';
            }
        ?>
        
        </div>        
    </div>
    

</body>
</html>