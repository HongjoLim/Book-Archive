<?php 

    require("header.php");
?>

<!-- jumbotron -->
<div class="jumbotron text-center">
    <img src="shared/img/logo.png" width="150" height="150"/>
    <h1 class="display-4">Book Archive</h1>
    <p class="h3 mt-3 text-muted">Find & post the book that means the most to you</p>
    <!-- searchbar -->
    <form class="form-inline justify-content-center mt-4 mb-0" 
        action="Controller/search_controller.php" method="POST">    
        <input type="search" class="form-control mr-sm-2" name="search" placeholder="Search books">
        <input type="hidden" name="action" value="title_search"/>
        <button type="submit" class="btn btn-secondary" value="Search">Search</button>
    </form>
    <!-- ./searchbar -->
</div>

<!-- ./jumbotron -->

<div class="container mr-auto mt-4 mb-3">
    <div class="container row mr-auto">
        <div class="container col-md-6 mb-4 mt-4"/>
            <img src="shared/img/books.png" class="rounded mx-auto d-block" width="100" height="100"/>
            <p class="h3 text-center mt-4 mb-4">REVIEW</p>
            <div class="container mr-auto">
            <p class="text-center"><a class="btn btn-outline-dark col-md-2" href="reviews.php"/>GO</a></p>
            </div>
        </div>

        <!-- if the user is not logged in, the user cannot post -->
        <?php if(isset($user)&&$user->is_logged()) :?>
        <div class="container col-md-6 mt-4 mb-4"/>
            <img src="shared/img/post.png" class="rounded mx-auto d-block" width="100" height="100"/>
            <p class="h3 text-center mt-4 mb-4">POST</p>
            <p class="text-center"><a class="btn btn-outline-dark col-md-2"
                href="post.php"/>GO</a></p>
        </div>
        <?php endif; ?>

    </div>

</div>

<?php include_once("footer.php");?>