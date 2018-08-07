<?php 

    /*
        Name: Hongjo Lim
        Date: Aug 4 2018
        Purpose: This is the controller to deal with user's 
                'sign in', 'sign out', 'log out' request
    */
    
    require_once("../Models/autoload.php");

    DatabaseObject::db_connect();
    # Make sure session is started
    session_start();
    /* 
    Name: Hongjo Lim
    Date: Aug 4, 2018
    Purpose: This is a controller for user authentication (sign in, sign up)
            If user's action is received, depending on which one it is (sign in, sign up)
            control the request
    */

    /* If the request method is not post, send the user back to index.php
        becuase that access is not what we expect
     */
    if($_SERVER['REQUEST_METHOD']!=="POST"){
        header("Location:../index.php");
        exit();
    }

    $action = filter_input(INPUT_POST, 'action');

    if($action=="sign_in"||$action=="sign_up"){
        # Custom method to grab user's inputs and store that in a variable
        $args = grab_user_inputs();
         # Make a user object and populate the properties
        if($args!=null){
            $user = new User($args);
        }else{
            $_SESSION['message'] = "Please try again!";
            header("Location:../index.php");
        }
    }

    # This method grabs user's inputs and store them in an array
    function grab_user_inputs(){

        $args = [];

        /*
            1. When the action is 'sign in',
                name value would be NOT SET
                (becuase there is no name field in the form)
            2. When the action is 'sign up',
                name value would be SET
                (becuase user needs to put his/her name in the form)
        */
        if(filter_input(INPUT_POST, 'name')!=null){
            $args['name'] = filter_input(INPUT_POST, 'name');
        }

        $args['email'] = filter_input(INPUT_POST, 'email');

        # Check if the password is more than 7 letters, if so, store it
        $args['password'] = filter_input(INPUT_POST, 'password');

        if(empty($args['email'])||empty($args['password'])||strlen($args['password'])<7){
            # User's input is not valid!!
            return null;
        }else{
            return $args;
        }

    }

    switch($action){

        # If the request is 'sign_in'
        case "sign_in":
            
            # The custom method 'login' in user object returns the user or null
            $user = $user->login();

            if($user!==null){

                #Log in successful
                $_SESSION['user_id'] = $user->id;
                $_SESSION['message'] = "Welcome ".$user->name."!";
                header("Location:../index.php");
            }else{
                $_SESSION['message'] = "Sign in failed"; 
                header("Location:../index.php"); 
            }
            

            break;

        # If the request is 'sign_up'
        case "sign_up":

            $lastInsertId = $user->register();

            if($lastInsertId>0){

                $user = User::get($lastInsertId);
                $_SESSION['message'] = "Welcome! Please Sign In!";
            }else{
                $_SESSION['message'] = "Sign up failed";
            }

            header('Location:../index.php');
            
            break;

        case "logout":
            session_destroy();
            unset($_SESSION['user_id']);
            header("Location:../index.php");
            break;

    }


?>