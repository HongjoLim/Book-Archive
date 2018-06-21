<?php 

    include("header.php");

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

    <!-- input filed to pass book id -->
    <input type="hidden" value="<?php echo $book['id'];?>" name="id"/>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Title</span>
            </div>
            <input type="text" value="<?php echo $book['title']; ?>" name="title" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Genre</span>
            </div>
            <select class="custom-select" id="genre" name="genre">
            <?php foreach($genres as $genre): ?>
                <option value="<?php echo $genre['name'];?>" <?php if($book['genre']==$genre['name']){echo "selected";}?>><?php echo $genre['name'];?></option>
            <?php endforeach; ?>
            </select>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Name</span>
            </div>
            <input type="text" value="<?php echo $book['person_name']; ?>" name="person_name" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Email</span>
            </div>
            <input type="email" value="<?php echo $book['person_email']; ?>" name="person_email" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
        </div>
            
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Link</span>
            </div>
            <input type="text" value="<?php echo $book['link']; ?>" name="link" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Image</span>
            </div>
            <div class="custom-file">
                <input type="file" name="image_path" placeholder="Choose File" class="custom-file-input" id="image_path">
                <label class="custom-file-label" for="image_path">Choose File</label>
            </div>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Store</span>
            </div>
            <input type="text" name="store" value="<?php echo $book['store']; ?>" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default">
        </div>
                
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Review</span>
            </div>
            <textarea rows="5" name="review" class="form-control" required/><?php echo $book['review']; ?></textarea>
            
        </div>
        <input type="hidden" name="id" value="<?php echo $book['id']?>" class="btn btn-primary"/>
        <button type="submit" name="submit" class="btn btn-primary">Edit Book</button>

</form>

<?php include("footer.php")?>