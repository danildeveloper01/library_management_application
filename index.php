<?php 
    include_once './block/header.php';
    $title = 'Welcome';
?>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-8 offset-md-2">
                <h1>Welckome</h1>
                <form action="/readers/readers.php" class="mt-5">
                    <button class="btn btn-success">Readers</button>
                </form> <br>
                <form action="/books/books.php" class="mt-2">
                    <button class="btn btn-success">Books</button>
                </form><br>
                <form action="/borrowed_books/borrowed_books.php" class="mt-2">
                    <button class="btn btn-success">History</button>
                </form><br>
            </div>
        </div>
    </div>
    

</body>
</html>