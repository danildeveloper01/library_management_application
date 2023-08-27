<?php 
include_once './block/header.php';
$title = 'Added';
?>


    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8 offset-md-2">
                <h1>Added</h1>
                <form action="/readers/readers.php" class="mt-5">
                    <button class="btn btn-success">Readers</button>
                </form> <br>
                <form action="/books/books.php" class="mt-2">
                    <button class="btn btn-success">Books</button>
                </form><br>
                <form action="/borrowed_books/borrowed_books.php" class="mt-2">
                    <button class="btn btn-success">Issuing or returning a book</button>
                </form><br>
            </div>
        </div>
    </div>
    

</body>
</html>