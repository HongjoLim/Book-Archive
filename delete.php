<?php 

    require_once("private/db_functions.php");

    #if the book_id is passed by get method,
    if(isset($_GET['id'])):
        $book_id = $_GET['id'];

        #using custom method, delete the book record using the book id
        delete_book($book_id);

        #send the user back to the book lists
        header("Location: ../reviews.php");
    endif;

?>