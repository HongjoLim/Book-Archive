<?php 

    # This file is to hold information of the Book object

    class Book extends DatabaseObject{

        # Here are the properties of a Book object
        public $id;
        public $title;
        public $genre;
        public $user_id;
        public $link = "";
        public $store = "";
        public $review = "";
        public $image_path = "";

        # Override the property in DatabaseObject class
        protected static $tableName = 'tbl_books';
        protected static $className = 'Book';

        # The contstructor which takes an array as a parameter
        public function __construct($args=[]){

            /* 
                Whenever an instance of this object is created, 
                make sure database connection is available
            */
            static::db_connect();

            if(!empty($args)){

                if(!empty($args['id'])){
                    $this->id = $args['id'];
                }
                
                static::db_connect();
 
                $this->title = $args['title'];
                $this->genre = $args['genre'];
                $this->user_id = $args['user_id'];
                $this->link = $args['link'];
                $this->store = $args['store'];
                $this->review = $args['review'];
                
                if(!empty($args['image_path'])){
                    $this->image_path = $args['image_path'];  
                }
              
            }
        }

        /* 
        AFTER a user object is instantiated, this method inserts the user's information
        into the database
        */
        public function insert(){

            # Build the SQL statement (using instance variable 'tableName')
            $sql = "INSERT INTO ".static::$tableName;
            $sql .= " (title, user_id, genre, link, store, review, image_path)";
            $sql .= " VALUES(:title, :user_id, :genre, :link, :store, :review, :image_path)";

            # Prepare
            $cmd = static::$conn->prepare($sql);

            # do the rest query by using the custom function
            $result = $this->do_the_rest_query($cmd);
            return $result;
        }

        public function update(){

            # Build the SQL statement (using instance variable 'tableName')
            $sql = "UPDATE ".static::$tableName;
            $sql .= " SET title = :title,";
            $sql .= " user_id = :user_id,";
            $sql .= " genre = :genre,";
            $sql .= " link = :link,";
            $sql .= " store = :store,";
            $sql .= " review = :review,";
            $sql .= " image_path = :image_path";
            $sql .= " WHERE id=:id";

            # Prepare
            $cmd = static::$conn->prepare($sql);

            $cmd->bindParam(":id", $this->id);

            # do the rest query by using the custom function
            $result = $this->do_the_rest_query($cmd);

            return $result;

        }

        private function do_the_rest_query($cmd){

            # Bind parameters using member variables in this class
            $cmd->bindParam(":title", $this->title);
            $cmd->bindParam(":genre", $this->genre);
            $cmd->bindParam(":user_id", $this->user_id);
            $cmd->bindParam(":link", $this->link);
            $cmd->bindParam(":store", $this->store);
            $cmd->bindParam(":review", $this->review);
            $cmd->bindParam(":image_path", $this->image_path);

            # Execute
            $result = $cmd->execute();

            # Close the cursor
            $cmd->closeCursor();

            return $result;
        }

    } # end of class

?>