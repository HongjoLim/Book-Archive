<?php 

    require_once("header.php");

    # Get the list of all genres by using a custom method in DatabaseObject class
    $genres = Genre::getAll();

    # If the user is not logged in, send the user back to the reviews.php
    if(!isset($user)||!$user->is_logged()){
        header("Location:reviews.php");
    }

    $book = null;
    /* 
        If the book id has been past (when updating the book), 
        find it in POST array, then initialize book object with that id
    */
    if(isset($_POST['id'])){
        $book = Book::get((int) $_POST['id']);
    }
    
?>
<!-- Page Content -->
<div class="container col-md-6 p-4 ml-4 mr-4 mt-2">

    <h4 class="mt-1">Post your favourite book</h1>
        
    <!-- go back to reviews button -->
    <a class="btn btn-outline-dark mt-2 mb-4" href="reviews.php">Back To List</a>
    <!-- go back to reviews button-->

    <!-- start of the form -->
    <form action="<?php echo "Controller/book_controller.php";?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?php if(isset($book->title)){echo $book->title;}?>" required />
            <small class="form-text text-muted">*This field is required</small>
        </div>

        <div class="form-group">
            <label>Genre</label>
            <select name="genre" class="form-control" required>
            <?php foreach($genres as $genre): ?>
                <option value="<?php echo $genre->name;?>"><?php echo $genre->name;?></option>
            <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">*This field is required</small>
        </div>

        <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" value="<?php echo $user->name;?>"
                disabled>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" value="<?php echo $user->email;?>" 
                disabled>
        </div>
                
        <div class="form-group">
            <label>Link</label>
            <input type="text" value="<?php if(isset($book->link)){echo $book->link;}?>" name="link" class="form-control">
        </div>

        <div class="form-group">
            <label for="image_path">Image</label>
            <input type="file" name="image_path" class="form-control-file" id="image_path"/>
        </div>

        <div class="form-group">
            <label>Store</label>
            <input type="text" name="store" value="<?php if(isset($book->store)){echo $book->store;}?>" class="form-control">
        </div>

        <div class="form-group">
            <label>Review</label>
            <textarea rows="5" name="review" class="form-control" required><?php if(isset($book->review)){echo $book->review;}?></textarea>
            <small class="form-text text-muted">*This field is required</small>
        </div>
        
        <!-- send user's info in a hidden input -->
        <input type="hidden" name="user_id" value="<?php echo $user->id;?>"/>
        
        <!-- if the book has been initilized (When this action is for updating the book) -->
        <?php if($book!==null){ ?>
        <!-- send the request to update -->
        <input type="hidden" name="action" value="update_book"/>
        <button type="submit" name="submit" class="btn btn-dark text-white">Update</button>
        <input type="hidden" name="id" value="<?php echo $book->id;?>"/>
        <?php }else{ ?>
        <!-- send an action to the controller -->
        <input type="hidden" name="action" value="post_book"/>
        <button type="submit" name="submit" class="btn btn-dark text-white">POST</button>
        <?php } ?>
    </form>
</div>

<?php include("footer.php")?>