<?php 

    $imagePath = "Img/";
    require_once("../Models/autoload.php");

    DatabaseObject::db_connect();

    session_start();

    # Constant for maximum picture size
    define("MAX_PIC_SIZE", "300000");

    /* 
        If the request is not POST, it is invalid entry, 
        send the user back to index page
    */

    if($_SERVER['REQUEST_METHOD']!=='POST'){
        header("location:../index.php");
        exit();
    }

    # variable to distinguish action (post book? delete book? update book?)
    $action = filter_input(INPUT_POST, 'action');

    /*
        Declare the book variable and set it to null, 
        as it needs to be initialized after going through some validation
    */

    $book = null;

    # If the action is to post or to update, grab the information
    if($action == 'post_book'||$action=="update_book"){
        
        # Grab the inputs from the post array by using custom method
        $book = grab_inputs();

        # After all the validation check, if null is passed, finish the script
        if($book===null){
            $_SESSION['message'] = "Unable to Post!";
            header("Location:../reviews.php");
            exit();
        }
    }else{

        $book = Book::get((int)$_POST['id']);

    }

    switch ($action){

        case "post_book":
            
            $result = $book->insert();

            # If the returned last inserted row is less than 0, show error!
            if(!$result){
                $_SESSION['message'] = "Unable to post!";
            }else{
                $_SESSION['message'] = "Successfuly posted your book!";
            }

            break;

        case "delete_book":
            
            if($book!==null){
                $book->delete();
            }
            break;

        case "update_book":
            
            $result = $book->update();

            if(!$result){
                $_SESSION['message'] = "Unable to update!";
            }else{
                $_SESSION['message'] = "Successfully updated!";
            }

            break;
    }

    header("Location:../reviews.php");

    # This is the actual end of this php file. Following parts are custom functions
   
    function grab_inputs(){
        
        $args = [];

        #get the data from post array and validate them
        if(!empty(filter_input(INPUT_POST, 'id'))){
            $args['id'] = filter_input(INPUT_POST, 'id');
        }

        $args['title'] = filter_input(INPUT_POST, 'title');
        $args['genre'] = filter_input(INPUT_POST, 'genre');
        $args['user_id'] = filter_input(INPUT_POST, 'user_id');
        $args['link'] = filter_input(INPUT_POST, 'link');
        $args['store'] = filter_input(INPUT_POST, 'store');
        $args['review'] = filter_input(INPUT_POST, 'review');
        $args['image_path'] = $_FILES['image_path']['name'];

        #if the user chooses to upload a pic, process the validation
        if(!empty($args['image_path'])){

            # A boolean value to check wheter file uploadin is done okay or not
            $file_ok = validate_pic();

            echo $file_ok;
            
            if(!$file_ok){
                return null;
            }
        }else if(!empty($book->image_path)){
            /* 
                To prevent losing the original image path 
                when the user does not input the path
            */
            $args['image_path'] = $book->image_path;
        }

        /* 
            Following statement is the case either file has NOT been uploaded,
            OR
            uploaded file is VALID
        */

        # If any of the required fields are empty, return null
        if(empty($args['title'])||
            empty($args['genre'])||
            empty($args['user_id'])||
            empty($args['review'])){

            return null;

        }

        # Initialize the book object and return it
        $book = new Book($args);
        
        return $book;
    }

    /*
        This custom function checks the validity of the file.
        If validation fails, returns false, otherwise, return true
    */
    function validate_pic(){

        # Grab information from the file that has been sent
        $path = $_FILES['image_path']['name'];
        $type = $_FILES['image_path']['type'];
        $size = $_FILES['image_path']['size'];

        # If the size of the file does not match the receivable size, return false;
        if($size<=0||$size>MAX_PIC_SIZE){
            return false;
        }

        # Check if the file meets certain file type limitation
        if(($type == 'image/gif') || 
            ($type == 'image/jpg') || 
            ($type == 'image/jpeg') || 
            ($type == 'image/png')) {

            if($_FILES['image_path']['error'] == 0) {
                    
                // where the image needs to go 
                $target = "Img/".$path; 
                            
                //move the file to the img folder 
                move_uploaded_file($_FILES['image_path']['tmp_name'], $target);

                return true;
            
            }else{
                return false;
            }
        }
        # If the file type is something else, return false;
        else{
            return false; 
        }
    }

?>