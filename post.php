<?php 

    require_once("header.php");

    #get all list of genres for select input
    $genres = find_all_genres();

    if($_SERVER['REQUEST_METHOD']=='POST'){

        $book = [];

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

            #if the size of the file does not match the criteria,
            if($book_pic_size<=0||$book_pic_size>MAX_PIC_SIZE){
                echo "<script>alert('Sorry. Inappropriate file size.')</script>";
                $file_ok=false;
            }else{
                #check if the file meets certain criteria(type&size)
                if(($book_pic_type == 'image/gif') || 
                ($book_pic_type == 'image/jpg') || 
                ($book_pic_type == 'image/jpeg') || 
                ($book_pic_type == 'image/png')) {

                    if($_FILES['image_path']['error'] == 0) {
                    
                        // where the image needs to go 
                        $target = $book_pic; 
                        
                        //move the file to the img folder 
                        move_uploaded_file($_FILES['image_path']['tmp_name'], $target);
                        $book['image_path'] = $book_pic;
                    }else{
                    
                        $file_ok = false;
                        echo "<script>alert('Failed to upload the file!');</script>";
                    }

                }else{
                    $file_ok = false;
                    echo "<script>alert('Failed to upload the file!');</script>";
                }
            }

        }
        /*
        required fields = 'title', 'genre', 'person_name', 'person_email', 'review'
        if any of these fields is empty, the posting cannot be processed
        */
        if(empty($book['title'])||empty($book['genre'])||empty($book['person_name'])||
            empty($book['person_email'])||empty($book['review'])||!$file_ok){
                echo '<div class="container"><p style="color:red;">Please fill all the required fields</p></div>';
                header("location: reviews.php");
        }else{
            
            /*If everything goes well,
            insert the book information into the database
            this custom function is in 'db_functions.php' file
            */
            insert_book($book);
            #send the user back to the 'reviews.php'
            header("Location: reviews.php");
            exit();
        }
    }
    
?>
<h3>Post your favourite book</h3>
<br/>
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
    <div class="container">

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required />
            <small class="form-text text-muted">*This field is required</small>
        </div>

        <div class="form-group">
            <label>Genre</label>
            <select name="genre" class="form-control" required>
            <?php foreach($genres as $genre): ?>
                <option value="<?php echo $genre['name'];?>"><?php echo $genre['name'];?></option>
            <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">*This field is required</small>
        </div>

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="person_name" class="form-control" required />
            <small class="form-text text-muted">*This field is required</small>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="person_email" class="form-control" required />
            <small class="form-text text-muted">*This field is required</small>
        </div>
            
        <div class="form-group">
            <label>Link</label>
            <input type="text" name="link" class="form-control">
        </div>

        <div class="form-group">
            <label for="image_path">Image</label>
            <input type="file" name="image_path" class="form-control-file" id="image_path"/>
        </div>

        <div class="form-group">
            <label>Store</label>
            <input type="text" name="store" class="form-control">
        </div>

        <div class="form-group">
            <label>Review</label>
            <textarea rows="5" name="review" class="form-control" required></textarea>
            <small class="form-text text-muted">*This field is required</small>
        </div>
     
        <input type="hidden" name="submit" value="Submit" class="btn btn-primary"/>
        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <input type="hidden" name="MAX_PIC_SIZE" value="<?php echo MAX_PIC_SIZE; ?>"/>
    </div>
</form>

<?php include("footer.php")?>