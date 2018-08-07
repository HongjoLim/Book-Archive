<?php 

    /*
        Name: Hongjo Lim
        Date: Aug 2 2018
        Purpose: This PHP file holds information of a user object
                as well as database functions that deal with the user table
    */

    class User extends DatabaseObject{

        public $id; # Working as a primary key
        public $email;
        public $password;
        public $name;

        # table name & class name
        protected static $tableName = 'tbl_user';
        protected static $className = 'User';

        public function __construct($args=[]){

            /* 
                Whenever an instance of this object is created, 
                make sure database connection is available
            */
            static::db_connect();

            /* If this object is created with retrieved data from database,
                user id would be available.
                However, if this object is created when the user is not in the database 
                there would be no id value
            */
            if(!empty($args)){
                
                if(isset($args['id'])){
                    $this->id = $args['id'];
                }

                $this->email = $args['email'];
                $this->password = $args['password'];

                /*
                    1. When this object is created with sign in request,
                        name value would be UNAVAILABLE
                        (becuase there is no name in the form)
                    2. When this object is created with sign up request,
                        name value would be AVAILABLE
                        (becuase user needs to put his/her name in the form)
                */
                if(isset($args['name'])){
                    $this->name = $args['name'];
                }
            }

        }

        public function is_logged(){
            
            if(isset($_SESSION['user_id'])){
                if($_SESSION['user_id']===$this->id){
                    return true;
                }
            }
            
            return false;
        }

        /* 
        AFTER a user object is instantiated, 
        this method inserts the user's information into the database
        */
        public function register(){

            # Build the SQL statement (using instance variable 'tableName')
            $sql = "INSERT INTO ".static::$tableName;
            $sql .= " (email, password, name)";
            $sql .= " VALUES(:email, :password, :name)";
            
            # Prepare
            $cmd = static::$conn->prepare($sql);
            
            # Bind parameters using member variables in this class - 
            # becuase this object is already instantiated
            $cmd->bindParam(":email", $this->email);

            # Hash the password before store that
            $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

            # Then bind the hashed password
            $cmd->bindParam(":password", $hashed_password);

            $cmd->bindParam(":name", $this->name);

            # Execute
            $result = $cmd->execute();

            $cmd->closeCursor();            

            if(!$result){
                return null;
            }
            # If everything goes well, send the user back to the login.php page
            else{
                return static::$conn->lastInsertId();

            }

        }

        public function login(){

            # Build the SQL statement (using instance variable 'tableName')
            $sql = "SELECT * FROM ".static::$tableName;
            $sql .= " WHERE email=:email";

            # Prepare
            $cmd = static::$conn->prepare($sql);
            
            # Bind parameters using member variables in this class - 
            # becuase this object is already instantiated
            $cmd->bindParam(":email", $this->email);

            # Execute
            $cmd->execute();

            # Set fetch mode
            $cmd->setFetchMode(PDO::FETCH_CLASS, static::$className);

            $user = new static;

            # Fetch
            while($record = $cmd->fetch()){
            
                foreach($record as $property=>$value){
                    if(property_exists($user, $property)){
                        $user->$property = $value;
                    }
                }

            }

            $result = password_verify($this->password, $user->password);

            if($result){
                return $user;
            }else{
                return null;
            }

        }

    } # end of class

?>