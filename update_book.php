<?php 

    require('header.php');

    if($_SERVER['REQUEST_METHOD']=='POST'){

        $book['id'] = $_POST['id'];

        #get the data from post array and validate them
        $book['title'] = filter_input(INPUT_POST, 'title');
        $book['genre'] = filter_input(INPUT_POST, 'genre');
        $book['person_name'] = filter_input(INPUT_POST, 'person_name');
        $book['person_email'] = filter_input(INPUT_POST, 'person_email', FILTER_VALIDATE_EMAIL);
        $book['link'] = filter_input(INPUT_POST, 'link');
        $book['store'] = filter_input(INPUT_POST, 'store');
        $book['review'] = filter_input(INPUT_POST, 'review');

        $book_pic = $_FILES['image_path']['name'];
        $book_pic_type = $_FILES['image_path']['type'];
        $book_pic_size = $_FILES['image_path']['size'];

        #varible to check wheter file uploadin is done okay or not
        $file_ok = true;

        #if the user chooses to upload a pic, process the validation
        if(!empty($book_pic)){

            #check if the file meets certain criteria(type&size)
            if(($book_pic_type == 'image/gif') || 
            ($book_pic_type == 'image/jpg') || 
            ($book_pic_type == 'image/jpeg') || 
            ($book_pic_type == 'image/png') && 
            ($book_pic_size > 0)) {
      
                if($_FILES['image_path']['error'] == 0) {
                  
                  // where the image needs to go 
                  $target = UPLOADPATH . $book_pic; 
                  
                  //move the file to the img folder 
                  if(move_uploaded_file($_FILES['image_path']['tmp_name'], $target));

                    $book['image_path'] = $book_pic;
                    echo "File UPLOADED";
                }else{
                    $file_ok = false;
                    echo "<script>alert('Failed to upload the file! 1');</script>";
                }
            }else{
                    $file_ok = false;
                    echo "<script>alert('Failed to upload the file! 2');</script>";
            }
        }
        /*
        required fields = 'title', 'genre', 'person_name', 'person_email', 'review'
        if any of these fields is empty, the posting cannot be processed
        */
        if(empty($book['title'])||empty($book['genre'])||empty($book['person_name'])||
            empty($book['person_email'])||empty($book['review'])||!$file_ok){
                echo '<div class="container"><p style="color:red;">Please fill all the required fields</p></div>';
        }else{
            update_book($book);
            header("Location: reviews.php");
        }
    }

?>