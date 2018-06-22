<?php 

    #require "db.php" file that has the PDO object
    require("db.php");

    function find_all_books(){
        
        # $conn variable is already declared in "db.php" file
        global $conn;

        try{

            $sql = "SELECT * FROM tbl_books";
    
            #prepare
            $cmd = $conn->prepare($sql);

            #execute
            $cmd->execute();

            #fetchall
            $books = $cmd->fetchAll();

            #close the connection
            $cmd->closeCursor();

        }catch(PDOException $e){
            header('location: error.php');
        }

        return $books;
    }

    function find_all_genres(){
        global $conn;

        try{

            #select all the genres from the table "tbl_genre" in our database
            $sql = "SELECT * FROM tbl_genre ORDER BY name";

            #prepare
            $cmd = $conn->prepare($sql);

            #execute
            $cmd->execute();

            $genres = [];
            #fetchAll
            $genres = $cmd->fetchAll();

            $cmd->closeCursor();
        }catch(PDOException $e){
            header("Location: error.php");
        }

        return $genres;
    }

    #the function to find a book by its id
    function find_book($book_id){
        global $conn;

        try{

            $sql = "SELECT * FROM tbl_books WHERE id=:id LIMIT 1";

            $cmd = $conn->prepare($sql);

            $cmd->bindParam(':id', $book_id, PDO::PARAM_INT);

            $cmd->execute();

            $book = $cmd->fetch();

            $cmd->closeCursor();

        }catch(PDOException $e){
            header("Location: error.php");
        }

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
            $cmd->bindParam(":title", $book['title'], PDO::PARAM_STR);
            $cmd->bindParam(":person_name", $book['person_name'], PDO::PARAM_STR);
            $cmd->bindParam(":person_email", $book['person_email'], PDO::PARAM_STR);
            $cmd->bindParam(":genre", $book['genre'], PDO::PARAM_STR);
            $cmd->bindParam(":link", $book['link'], PDO::PARAM_STR);
            $cmd->bindParam(":store", $book['store'], PDO::PARAM_STR);
            $cmd->bindParam(":image_path", $book['image_path'], PDO::PARAM_STR);
            $cmd->bindParam(":review", $book['review'], PDO::PARAM_STR);

            $cmd->execute();

            $cmd->closeCursor();
   
        }catch(Exception $e){
            header("Location: error.php");
        }

    }

    function update_book($book){

        global $conn;

        try{

            $sql = "UPDATE tbl_books SET
            title = :title, 
            person_name = :person_name, 
            person_email = :person_email, 
            genre = :genre, 
            link = :link, 
            store = :store, 
            image_path = :image_path, 
            review = :review WHERE id = :id";

            $cmd = $conn->prepare($sql);

            #bind parameters
            $cmd->bindParam(":title", $book['title'], PDO::PARAM_STR);
            $cmd->bindParam(":person_name", $book['person_name'], PDO::PARAM_STR);
            $cmd->bindParam(":person_email", $book['person_email'], PDO::PARAM_STR);
            $cmd->bindParam(":genre", $book['genre'], PDO::PARAM_STR);
            $cmd->bindParam(":link", $book['link'], PDO::PARAM_STR);
            $cmd->bindParam(":store", $book['store'], PDO::PARAM_STR);
            $cmd->bindParam(":image_path", $book['image_path'], PDO::PARAM_STR);
            $cmd->bindParam(":review", $book['review'], PDO::PARAM_STR);
            $cmd->bindParam(":id", $book['id'], PDO::PARAM_INT);

            $cmd->execute();
            
            $cmd->closeCursor();
   
        }catch(Exception $e){
            header("Location: error.php");
        }

    }

    #function to delete a book record by book_id
    function delete_book($book_id){
        
        global $conn;

        try{

            $sql="DELETE FROM tbl_books WHERE id=:id LIMIT 1";

            $cmd = $conn->prepare($sql);

            $cmd->bindParam(":id", $book_id, PDO::PARAM_INT);

            $cmd->execute();

            $cmd->closeCursor();
        
        }catch(PDOException $e){
        
            header("location: error.php");
        }
    }

?>