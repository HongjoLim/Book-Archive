<?php 

    require_once('header.php');

    if($_GET['id']){

        #find the book by its id using custom function
        $book = Book::get($_GET['id']);
    }

?>
<div class="container p-4 mr-auto mt-2">

    <h4>Review Details</h4>
    <!-- go back to reviews button -->
    <a class="btn btn-outline-dark mt-2 mb-4" href="reviews.php">Back To List</a>
    <!-- go back to reviews button-->
    <div class="row p-4">
        <div class="col-md-3 col-lg-3 p-2 text-center mt-4" align="center"> 
            <img alt="Book Picture" width="200" height="250" 
                src="<?php if(!empty($book->image_path)){echo $imagePath.$book->image_path;}
                else{echo "shared/img/post.png";}?>"
                class="img-fluid mt-1">
        </div>
        <div class=" col-md-9 col-lg-9 "> 
        <table class="table">
            <tbody>
                <tr>
                    <td width="20%">Title</td>
                    <td><?php echo $book->title;?></td>
                </tr>
                <tr>
                    <td width="20%">Genre</td>
                    <td><?php echo $book->genre; ?></td>
                </tr>
                <tr>
                    <td width="20%">User Name</td>
                    <td><?php echo User::get($book->user_id)->name;?></td>
                </tr>
                <tr>
                    <td width="20%">User Email</td>
                    <td><?php echo User::get($book->user_id)->email;?></td>
                </tr>
                <tr>
                    <td width="20%">Link</td>
                    <td><?php echo $book->link;?></td>
                </tr>
                <tr>
                    <td width="20%">Store</td>
                    <td><?php echo $book->store;?></td>
                </tr>
                <tr>
                    <td width="20%">Review</td>
                    <td><p><?php echo $book->review;?></p></td>
                </tr>
            </tbody>
        </table>

    <!-- update and delete button is only visible when the user is logged in -->
    <?php if($user!==null&&$user->is_logged()&&$user->id==$book->user_id):?>
    <div class="btn-group">
        <div class="row">
            <div class="col-md-6">
                <!-- start of update button -->
                <form action="post.php" method="post">
                    <button type="submit" class="btn btn-dark text-white mr-3">Update</button>
                    <input type="hidden" name="id" value="<?php echo $book->id;?>"/>
                </form>
                <!-- end of update button -->
            </div>
            <div class="col-md-6">
                <!-- start of delete button -->
                <form action="Controller/book_controller.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $book->id;?>"/> 
                    <button type="submit" class="btn btn-dark text-white" onclick="confirm('Are you sure?');">Delete</button>
                    <input type="hidden" name="action" value="delete_book"/>
                </form>
                <!-- end of delete button -->
            </div>
        </div>
    </div>

    <!-- end of delete & update button -->
    <?php endif; ?>

</div>