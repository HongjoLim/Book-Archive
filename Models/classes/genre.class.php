<?php 

    # This php file is to store information of a book genre
    class Genre extends DatabaseObject{

        public $id;
        public $name;

        # Fiction or Non-Fiction?
        public $type;

        # table name & class name
        protected static $tableName = "tbl_genre";
        protected static $className = "Genre";

        # Constructor
        public function __contruct($args=[]){

            /* 
                Whenever an instance of this object is created, 
                make sure database connection is available
            */
            static::db_connect();

            if(!empty($args)){
                if(isset($args['id'])){
                    $this->id = $args['id'];
                }

                $this->name = $args['name'];
                $this->type = $args['type'];
            }

        }

    } # end of class


?>