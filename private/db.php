<?php 

    try{

        #instantiate PDO object
        $conn = new PDO("mysql:host=127.0.0.1:55611;dbname=localdb", "azure", "6#vWHD_$");
        
        #setting error mode to errmode exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    }catch(PDOException $e){
       
        #show customized error page
        header("error.php");
    }

?>