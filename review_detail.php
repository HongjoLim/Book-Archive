<?php 

    require('header.php');

    if($_GET['id']){

        #find the book by its id using custom function
        $book = find_book($_GET['id']);
    }

?>

<h3>Book Details</h3>
<br/>
<div class="container mt-3 mb-3">

    <div class="row">
        <div class="col-md-3 col-lg-3 " align="center"> 
            <img alt="Book Picture" src="<?php echo UPLOADPATH.$book['image_path'];?>" class="img-circle img-responsive"> 
        </div>
        <div class=" col-md-9 col-lg-9 "> 
        <table class="table">
            <tbody>
                <tr>
                    <td width="20%">Title</td>
                    <td><?php echo $book['title'];?></td>
                </tr>
                <tr>
                    <td width="20%">User Name</td>
                    <td><?php echo $book['person_name'];?></td>
                </tr>
                <tr>
                    <td width="20%">User Email</td>
                    <td><?php echo $book['person_email'];?></td>
                </tr>
                <tr>
                    <td width="20%">Link</td>
                    <td><?php echo $book['link'];?></td>
                </tr>
                <tr>
                    <td width="20%">Store</td>
                    <td><?php echo $book['store'];?></td>
                </tr>
                <tr>
                    <td width="20%">Review</td>
                    <td><p><?php echo $book['review'];?></p></td>
                </tr>
            </tbody>
        </table>
        <a class="btn btn-primary mr-" role="button" href="edit.php?id=<?php echo $book['id'];?>">Update</a>
        <a class="btn btn-primary mr-3" role="button" href="delete.php?id=<?php echo $book['id'];?>">Delete</a>
    </div>
</div>