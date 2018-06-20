<?php 

    #require "db.php" file that has the PDO object
    require("db.php");

    function find_all_books(){
        # $conn variable is already declared in "db.php" file
        global $conn;

        $sql = "SELECT * FROM tbl_books";
    
        #prepare
        $cmd = $conn->prepare($sql);

        #execute
        $cmd->execute();

        #fetchall
        $books = $cmd->fetchAll();

        return $books;
    }

    function find_all_genres(){
        global $conn;

        #select all the genres from the table "tbl_genre" in our database
        $sql = "SELECT * FROM tbl_genre ORDER BY name";

        #prepare
        $cmd = $conn->prepare($sql);

        #execute
        $cmd->execute();

        $genres = [];
        #fetchAll
        $genres = $cmd->fetchAll();

        return $genres;
    }

    #the function to find a book by its id
    function find_book($book_id){
        global $conn;

        $sql = "SELECT * FROM tbl_books WHERE id=:id LIMIT 1";

        $cmd = $conn->prepare($sql);

        $cmd->bindParam(':id', $book_id);

        $cmd->execute();

        $book = $cmd->fetch();

        return $book;
    }

    function insert_book($book){

        global $conn;

        try{
            $sql = "INSERT INTO tbl_books(title, person_name, person_email, genre, 
            link, store, image_path, review) VALUES
            (:title, :person_name, :person_email, :genre, :link, :store, :image_path, :review)";

            $cmd = $conn->prepare($sql);

            #bind parameters
            $cmd->bindParam(":title", $book['title']);
            $cmd->bindParam(":person_name", $book['person_name']);
            $cmd->bindParam(":person_email", $book['person_email']);
            $cmd->bindParam(":genre", $book['genre']);
            $cmd->bindParam(":link", $book['link']);
            $cmd->bindParam(":store", $book['store']);
            $cmd->bindParam(":image_path", $book['image_path']);
            $cmd->bindParam(":review", $book['review']);

            $result = $cmd->execute();
            
            if($result){
                echo '<script>alert("Thank you for your posting!");<script>';
            }else{
                header("Location: error.php");
            }
        }catch(Exception $e){
            header("Location: error.php");
        }

    }

?>