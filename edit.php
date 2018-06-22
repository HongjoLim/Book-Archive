<?php 

    require_once("header.php");

    #get all list of genres for select input
    $genres = find_all_genres();

    #the book id is passed from "review_detail.php" file
    $book_id = $_GET['id'];

    #get the book info from the database to prepopulate input fields
    $book = find_book($book_id);
    
?>
<h3>Edit</h3>
<br/>
<form action="update_book.php" method="POST" enctype="multipart/form-data">
    <div class="container">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" value="<?php echo $book['title']; ?>" class="form-control" required />
            <small class="form-text text-muted">*This field is required</small>
        </div>

        <div class="form-group">
            <label>Genre</label>
            <select name="genre" class="form-control" required>
            <?php foreach($genres as $genre) : ?>
                <option value="<?php echo $genre['name'];?>" <?php if($book['genre']==$genre['name']){echo "selected";} ?> > <?php echo $genre['name'];?></option>
            <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">*This field is required</small>
        </div>

        <div class="form-group">
            <label>Name</label>
            <input type="text" name="person_name" value="<?php echo $book['person_name']; ?>" class="form-control" required />
            <small class="form-text text-muted">*This field is required</small>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="person_email" value="<?php echo $book['person_email']; ?>" class="form-control" required />
            <small class="form-text text-muted">*This field is required</small>
        </div>
            
        <div class="form-group">
            <label>Link</label>
            <input type="text" name="link"  value="<?php echo $book['link']; ?>" class="form-control"/>
        </div>

        <div class="form-group">
            <label for="image_path">Image</label>
            <input type="file" name="image_path" class="form-control-file" id="image_path">
        </div>

        <div class="form-group">
            <label>Store</label>
            <input type="text" name="store" value="<?php echo $book['store']; ?>" class="form-control"/>
        </div>

        <div class="form-group">
            <label>Review</label>
            <textarea rows="5" name="review" class="form-control" required><?php echo $book['review']; ?></textarea>
            <small class="form-text text-muted">*This field is required</small>
        </div>
        
        <input type="hidden" name="MAX_PIC_SIZE" value="<?php echo MAX_PIC_SIZE; ?>"/>
        <input type="hidden" name="id" value="<?php echo $book['id']?>" class="btn btn-primary"/>
        <button type="submit" name="submit" class="btn btn-primary">Edit Book</button>
    </div>
</form>

<?php include("footer.php");?>