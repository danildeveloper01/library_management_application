<?php 
    $title = 'Readers';

    include_once '../block/header.php';

    require_once '../db/configDB.php';
    
    $searchResults = [];

    /*The search functionality is written. Expose the block with the code

    if(isset($_GET['searchId']) && !empty($_GET['searchId'])){
        $searchId = $_GET['searchId'];

        if(is_numeric($searchId)) {
            $searchQuery = "SELECT * FROM `readers` WHERE `id` = ?";
            $stmt = $pdo->prepare($searchQuery);
            $stmt->execute([$searchId]);
            $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $searchQuery = "SELECT * FROM `readers` WHERE `id` LIKE ? OR `id` LIKE ?";
            $searchIdPattern = '%' . $searchId . '%';
            $stmt = $pdo->prepare($searchQuery);
            $stmt->execute([$searchIdPattern, $searchIdPattern]);
            $searchResults = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }*/
?>
    <div class="container">
       <?php
            include_once '../block/link.php';
       ?>
        <h1>New reader</h1>
        <form action="newreader.php" method="post" class="mt-4">
            <input type="text" name="name" id="name" class="form-control mt-3" placeholder="Name" required>
            <input type="text" name="surname" id="surname" class="form-control mt-3" placeholder="Surname" required>
            <input type="text" name="idCard" id="idCard" class="form-control mt-3" placeholder="ID card number" required>
            <input type="date" name="date" id="date" class="form-control mt-3" placeholder="Birthdate" required>
            <button type="submit" class="btn btn-success mt-4">Retain the reader</button>
        </form>

        <!-- The search functionality is written. Expose the block with the code
        
        <h1 class="mt-4 mb-4">Search</h1>
        <form action="" method="get" class="mt-4">
            <input type="text" name="searchId" class="form-control" placeholder="Search by ID card number">
            <button type="submit" class="btn btn-primary mt-2">Search</button>
        </form>    

        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center mt-4">
            <?php 
                /*foreach ($searchResults as $result) {
                    echo '<div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm">
                                <div class="card-body">';
                    echo '<ul class="list-unstyled mt-3 mb-4">';
                    echo '<h4 class="my-0 fw-normal">' . $result['name'] . ' ' . $result['surname'] . '</h4>';
                    echo '<li>ID card number: ' . $result['id'] . '</li>';

                    if (!empty($result['date'])) {
                        $formattedDate = date("d.m.Y", strtotime($result['date']));
                        echo '<li>Birthdate: ' . $formattedDate . '</li>';
                    } else {
                        echo '<li>Birthdate: </li>';
                        
                    }
                    echo '<a href="../delete.php?id='.$row->id.'">Delete</a>';
                    echo '</ul>';
                    echo '</div>
                            </div>
                        </div>';
                }*/
            ?>
        </div> -->   
        <h1 class="mt-4 mb-4">Readers</h1>  
        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">           
            <?php             
                $readersQuery = $pdo->query('SELECT * FROM `readers` ORDER BY `surname` ASC');

                while ($readerRow = $readersQuery->fetch(PDO::FETCH_OBJ)) {
                    echo '<div class="col">
                            <div class="card mb-4 rounded-3 shadow-sm">
                                <div class="card-body">';                                        
                                    echo '<ul class="list-unstyled mt-3 mb-4">';
                                    echo '<h4 class="my-0 fw-normal">' . $readerRow->name . ' ' . $readerRow->surname . '</h4>';
                                    echo '<li class="mt-4"><b>ID card number:</b> ' . $readerRow->id . '</li>';
                                    if (!empty($readerRow->date)) {
                                        $formattedDate = date("d.m.Y", strtotime($readerRow->date));
                                        echo '<li class="mt-2"><b>Birthdate:</b> ' . $formattedDate . '</li>';
                                    } else {
                                        echo '<li><b>Birthdate:</b> ERROR </li>';
                                    }
                                    echo '</ul>';                        
                                    
                                    //redaction forms
 
                                    echo '<form action="editReader.php" method="post">';
                                    echo '<input type="hidden" name="reader_id" value="' . $readerRow->id . '">';
                                    echo '<input type="text" name="new_name" id="new_name" class="form-control" placeholder="Redaction name" required>';
                                    echo '<input type="text" name="new_surname" id="new_surname" class="form-control mt-2" placeholder="Redaction surname" required>';
                                    echo '<button type="submit" class="btn btn-success w-50 mt-4 mb-4">Edit</button>';
                                    echo '</form>';
                                   
                                    
                                    echo '<a href="../delete.php?id='.$readerRow->id.'">Delete</a>';                            
                                echo '</div>
                            </div>
                        </div>';
                }
            ?>  
        </div>

    </div>
    

</body>
</html>