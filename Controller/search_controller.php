<?php 

    /*
        Name: Hongjo Lim
        Date: Aug 6 2018
        Purpose: This is the controller to deal with search functions
                1. Basically, it builds a "SQL query statement" with the values in POST array
                2. pass it back to the reviews.php 
                3. changes the content in reviews.php

    */

    /*
        Case 1: search for 'title' (user enters values in the search bar and clicks button)               
        $POST['action'] = "title_search"           
        $POST['search'] = the name of the books    
        ________________________________________
        
        Case 2: search for 'genre' (user clicks one of the list tags on the 'Genres' side bar)
        $POST['action'] = "genre_search"
        $POST['search'] = $genre->name; (This can vary as we have namy genres)

        In this case, we only have 1 string value(one of the predefined names of genres by me)

    */

    if($_SERVER['REQUEST_METHOD']!=="POST"){
        header("location:../index.php");
    }

    $action = $_POST['action'];

    # In both cases, searching for genre or title share the same title for value in POST array
    $search = $_POST['search'];

    $whereCondition = "";

    switch($action){

        /* 
            This case is when the user clicks one of the side bar menus
            to search a certain genre
        */
        case "genre_search":

            # This is because ONLY 1 string value (genre name) has been passed
            $whereCondition = " genre = '$search'";

            break;

        /* 
            This case is when the user clicks one of the side bar menus
            to search a certain genre
        */
        case "title_search":
            $words = explode(' ', $search);

            $whereCondition = " title LIKE ";

            foreach($words as $word){
                $whereCondition .= "'%$word%' OR ";
            }

            $whereCondition = substr($whereCondition, 0, strlen($whereCondition)-4);

            break;
    }

    session_start();

    # Store the where condition in the session(I do not know the better way..)
    $_SESSION['whereCondition'] = $whereCondition;
    header("Location:../reviews.php");

?>