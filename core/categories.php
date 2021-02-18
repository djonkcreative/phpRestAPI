<?php 
    class Categories{
        //db stuff
        private $conn;
        private $table = 'categories';

        //categories properties
        public $id;
        public $name;
        public $create_at;

        //constructor with db connection
        public function __construct($db){
            $this->conn = $db;  
        }

        //getting post from our database;
        public function read(){
            //create query
            $query = "SELECT * FROM $this->table";
        //prepare statement
        $stmt = $this->conn->prepare($query);
        //execute query
        $stmt->execute();
        return $stmt;
        }

        public function read_single(){
            //create query
                $query = "SELECT *
                            FROM $this->table
                            WHERE id =? LIMIT 1";
        //prepare statement
        $stmt = $this->conn->prepare($query);
        //binding paramates
        $stmt->bindParam(1, $this->id);
        //execute the query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        }

        //create query
        public function create(){
            $query = "INSERT INTO $this->table SET name = :name";
            //prepate statement
            $stmt = $this->conn->prepare($query);
            //clean data
            $this->name = htmlspecialchars(strip_tags($this->name));
           
            //binding of parameters
            $stmt->bindParam(':name', $this->name);
            //execute the query
            if($stmt->execute()){
                return true;
            }
            //print error if somethings goes wrong
            print_r("Error %s. \n", $stmt->error);
            return false;
        }

        //update query
        public function update(){
            //create query
            $query = "UPDATE $this->table 
                    SET name = :name,
                    WHERE id=:id";
            //prepate statement
            $stmt = $this->conn->prepare($query);
            //clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->name = htmlspecialchars(strip_tags($this->name));
            
            //binding of parameters
            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':name', $this->name);
           
            //execute the query
            if($stmt->execute()){
                return true;
            }
            //print error if somethings goes wrong
            print_r("Error %s. \n", $stmt->error);
            return false;
        }

        //delete query
        public function delete(){
            $query = "DELETE FROM $this->table WHERE id = :id";

            //prepate statement
            $stmt = $this->conn->prepare($query);
            //clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            //binding the id parameter
            $stmt->bindParam(':id', $this->id);
            
            //execute the query
            if($stmt->execute()){
                return true;
            }

            //print error if something goes wrong
            print_r("Error %s. \n", $stmt->error);
            return false;
        }



}
?>