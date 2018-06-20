<?php 

    #require "db_functions.php" file that has database CRUD functions in it
    require_once("private/db_functions.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Book Archaive</title>
        <meta charset="UTF-8/"/>

        <meta name="viewport" content="width=width-device, initial-scale=1"/>

        <!-- bootstrap css file -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
        <!-- bootstrap javascript file -->
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js">
        </script>
        <!-- jquery -->
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </head>
    <body>

    <!-- start of navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <a class="navbar-brand" href="index.php">Book Archive</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">HOME<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="reviews.php">REVIEWS</a>
                    </li>
                </ul>

                <!-- search button -->
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </nav>

        <!-- end of navigation menu -->

<div class="container mt-3">