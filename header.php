<?php 

    # Start the buffer
    ob_start();

    $imagePath = "Controller/Img/";
    require_once("Models/autoload.php");

    # set the database connection using custom method in DatabaseObject class
    DatabaseObject::db_connect();

    session_start();

    # If any message has been passed from before this page, show the error
    if(isset($_SESSION['message'])){
        echo "<script>alert('".$_SESSION['message']."')</script>";
        unset($_SESSION['message']);
    }

    $user = null;

    # Check if the user is logged in
    if(isset($_SESSION['user_id'])){

        /* If any user is logged in,
            Make a user object and populate current logged in user's information
            This variable will be available throughout the whole pages
        */

        $user = User::get($_SESSION['user_id']);
        
    }

?>

<!DOCTYPE html>
<html>

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Book Archive</title>

        <!-- Bootstrap core CSS -->
        <link rel="stylesheet" 
            href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
            integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" 
            crossorigin="anonymous">

        <!-- Custom fonts -->
        <link href="shared/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="shared/css/simple-line-icons.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- Custom styles -->
        <link href="css/style.css" rel="stylesheet">

        <!-- Bootstrap core Java Script & JQuery -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" 
            crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" 
            crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" 
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" 
            crossorigin="anonymous">
        </script>

    </head>
    <body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">

            <!-- logo and navbar-brand -->
            <span>
                <img src="shared/img/logo_sm.png" class="rounded mt-0 mb-3 mr-2"
                     width="32" height="32"/>
                <a class="navbar-brand" href="index.php">
                <h3>Book Archive</h3></a>
            </span>
            
            <!-- ./logo and navbar-brand -->

            <!-- 'Sign in' & 'Sign out' OR 'Log out' button -->
            <div class="btn-group">
            <?php if(isset($user)&&$user->is_logged()){ ?>
                <!-- create form tag to send post request in case of 'logout' -->
                <form action="Controller/auth_controller.php" method="post">
                    <input type="hidden" name="action" value="logout"/>
                    <input class="btn btn-outline-light my-2 mt-2" type="submit" value="Log out" onclick="alert('Bye!')" class="btn btn-outline-light"/>
                </form>
            <?php }else{ ?>
                    <a class="btn btn-outline-light mr-2" href="#loginForm" 
                        data-toggle="modal">Sign In</a>
                    <a class="btn btn-outline-light" href="#registerForm"
                        data-target="#registerForm" data-toggle="modal">Sign Up</a>
            <?php } ?>
            </div>
                
            <!-- ./'Sign in' & 'Sign out' OR 'Log out' button -->

        </div>
    </nav>

    <!-- login modal form -->

    <div class="modal fade" id="loginForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form style="padding:1.1rem;" 
                        action="Controller/auth_controller.php" method="post">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" placeholder="your_email@example.com" 
                                class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" placeholder="password"
                                class="form-control" required/>
                        </div>
                        <input type="hidden" name="action" value="sign_in"/>
                        <input type="submit" class="btn btn-dark text-light mt-3" value="Sign In"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ./login modal form -->

    <!-- register modal form -->

    <div class="modal fade" id="registerForm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form style="padding:1.1rem;" 
                        action="Controller/auth_controller.php" method="post">
                        <div class="form-group">
                            <label for="email">*Email</label>
                            <input type="email" placeholder="your_email@example.com" 
                                class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">*Password</label>
                            <input type="password" name="password" class="form-control"
                            placeholder="password" required>
                            <small>Please use more than 7 letters</small>
                        </div>
                        <div class="form-group">
                            <label for="name">*Name</label>
                            <input type="text" name="name" placeholder="Your name" 
                                class="form-control" required>
                        </div>
                        <input type="hidden" name="action" value="sign_up">
                        <input type="submit" class="btn btn-dark text-light mt-3" value="Sign Up"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ./register model form -->