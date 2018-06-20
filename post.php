<?php 

    include("header.php");

    #get all list of genres for select input
    $genres = [];
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
        $book['image'] = filter_input(INPUT_POST, 'image');
        $book['review'] = filter_input(INPUT_POST, 'review');

        /*
        required fields = 'title', 'genre', 'person_name', 'person_email', 'review'
        if any of these fields is empty, the posting cannot be processed
        */
        if(empty($book['title'])||empty($book['genre'])||empty($book['person_name'])||
            empty($book['person_email'])||empty($book['review'])){
                echo '<div class="container"><p style="color:red;">Please fill all the required fields</p></div>';
                echo $book['title'];
                echo $book['genre'];
                $book['person_name'];
                $book['person_email'];
                $book['link'];
                $book['store'];
                $book['image'];
                $book['review'];
        
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
<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    <div class="container">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Title</span>
            </div>
            <input type="text" name="title" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Genre</span>
            </div>
            <select class="custom-select" id="genre" name="genre">
            <?php foreach($genres as $genre): ?>
                <option value="<?php echo $genre['name'];?>"><?php echo $genre['name'];?></option>
            <?php endforeach; ?>
            </select>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Name</span>
            </div>
            <input type="text" name="person_name" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Email</span>
            </div>
            <input type="email" name="person_email" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
        </div>
            
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Link</span>
            </div>
            <input type="text" name="link" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Image</span>
            </div>
            <div class="custom-file">
                <input type="file" name="image" class="custom-file-input" id="image">
                <label class="custom-file-label" for="file">Choose file</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Store</span>
            </div>
            <input type="text" name="store" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
        </div>
                
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Review</span>
            </div>
            <textarea rows="5" name="review" value="" class="form-control" required/></textarea>
            
        </div>
        <input type="hidden" name="submit" value="Submit Movie" class="btn btn-primary"/>
        <button type="submit" name="submit" class="btn btn-primary">Submit Book</button>

</form>

<?php include("footer.php")?>