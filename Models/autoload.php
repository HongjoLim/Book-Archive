<?php 

    /* This php file uses auto_load function 
        to auto loads all the classes in this application
    */

    function my_autoload($class){
        if(preg_match('/\A\w+\Z/', $class)){
            include 'classes/' . $class . '.class.php';
        }
    }

    spl_autoload_register('my_autoload');
    
?>