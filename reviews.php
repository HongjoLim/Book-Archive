<?php 

    include("header.php");

    //find all books using custom function
    $books = find_all_books();

?>

<h3>Book Reviews</h3>
<br/>
<div class="container mb-3">
    <a class="btn btn-primary" href="post.php" role="button">POST</a>
</div>

<!-- start of the book table -->
<div class="table-responsive">
    <table class="table table-condensed table-bordered table-hover">
        <thead>
            <tr>
                <th class="text-center" width="5%">Number</th>
                <th class="text-center" width="70%">Title</th>
                <th class="text-center" width="15%">Name</th>
            </tr>
        </thead>
            <?php 
                #variable for the number of posting in the table
                $i=1;
                foreach($books as $book) :
            ?>
            <tr>
                <td class="text-center"><?php echo $i++; ?></td>
                <td class="text-left p-3"><a href="review_detail.php?id=<?php echo $book['id'];?>"><?php echo $book['title']; ?></a></td>
                <td class="text-center"><?php echo $book['person_name']; ?></td>
            </tr>
                <?php endforeach; #the end of foreach loop ?>
    </table>
</div>

<?php 

    include("footer.php");

?>