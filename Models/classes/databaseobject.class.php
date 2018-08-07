<?php 

    /* 
    Name: Hongjo Lim
    Date: Aug 3, 2018
    Purpose: This is the super class for every database object (book, genre, user)
            This class is going to be extended by 3 classes (book, genre, user)
            It is built to AVOID duplicate codes,
            becuase R & D (amoung CRUD) queries are quite the same.
    */

    class DatabaseObject{

        # Those properties MUST BE overriden in sub-classes
        protected static $tableName;
        protected static $className;
        protected static $conn;

        # Custom function to get database connection
        static public function db_connect(){

        
            try{

                #instantiate PDO object
                $conn = new PDO("mysql:host=127.0.0.1:55611;dbname=localdb", "azure", "6#vWHD_$");
            
                #setting error mode to errmode exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $conn;
        
            }catch(PDOException $e){
            
                #show customized error page
                header("error.php");
            }
        

            #static::$conn = 
                #new PDO("mysql:host=localhost;dbname=comp1006", "root", "");

        }

        /* 
        STATIC method - DOES NOT NEED TO BE INSTANTIATED
        This method finds ONE record of the object 
        with specific 'id' value that has been passed as the parameter
        */
        public static function get($id){

            # Build SQL statement
            $sql = "SELECT * FROM ".static::$tableName;
            $sql .= " WHERE id=:id LIMIT 1";

            # Prepare
            $cmd = static::$conn->prepare($sql);

            # Bind the parameter
            $cmd->bindParam(":id", $id, PDO::PARAM_INT);

            #Execute
            $cmd->execute();

            $cmd->setFetchMode(PDO::FETCH_CLASS, static::$className);

            # Initialize an object(whatever that is - WILL BE one of the sub-classes)
            $object = new static;

            while($record = $cmd->fetch()){

                # Loop to assign values of each column of a row in the object
                foreach($record as $property => $value){

                    # Check if the property really exists in the object
                    if(property_exists($object, $property)){

                        $object->$property = $value;
                    }
                }
            }

            # Return the book object
            return $object;

        }

        # This method returns multiple objects (or All of them) from the database
        # It also takes optional parameter that can be attached as where condition
        public static function getAll($whereCondition=""){

            # Build SQL statement
            $sql = "SELECT * FROM ".static::$tableName;

            if(!empty($whereCondition)){
                $sql .= " WHERE ".$whereCondition;
            }

            # Prepare
            $cmd = static::$conn->prepare($sql);

            #Execute
            $cmd->execute();

            $cmd->setFetchMode(PDO::FETCH_CLASS, static::$className);

            # Declare an array that is going to hold multiple Book objects

            $objects = [];

            while($record = $cmd->fetch()){

                # Initialize an object
                $object = new static;

                # Loop to assign values of each column of a row in the object
                foreach($record as $property => $value){

                    # Check if the property really exists in the object
                    if(property_exists($object, $property)){

                        $object->$property = $value;
                    }
                }

                # Store a Book object into an array of Book objects
                $objects[] = $object;
            }

            # Return the array of Book objects

            return $objects;
        }

        /* 
        AFTER a user object is instantiated, 
        this method deletes the user's information
        from the database
        */
        public function delete(){

            # Build SQL statement
            $sql = "DELETE FROM ".static::$tableName;
            $sql .= " WHERE id = :id LIMIT 1";

            # Prepare
            $cmd = static::$conn->prepare($sql);

            # Bind the 'id' parameter
            $cmd->bindParam(":id", $this->id, PDO::PARAM_INT);

            # Execute
            $result = $cmd->execute();

            # If the deletion is done wrong, show an error
            if(!$result){
                # TO DO: SHOW ERROR!
            }else{

                # Unset the session variable and terminate the session
                
                # send the user to the main page
                header("Location:../index.php");
            }
        }

    } # end of class

?>