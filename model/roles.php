<?php
    class Role
    {
        private $conn;

        public $id;
        public $title;
        public $description;
        public $deleted;
        public $permission;

        public function __construct($db){
            $this->conn = $db;
        }

        public function read(){
            $sql = "Select * from role where deleted=false";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function create(){
            $sql = "Insert Into role (title, description) 
            VALUES (:title, :description)";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }

        public function delete(){
            $sql = "Update role set deleted=true where id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
           
            return false;
        }

        public function detail(){
            
            $sql = "Select * from role where id=:id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $row['id'];
            $this->title = $row['title'];
            $this->description = $row['description'];

        }

        public function update(){
            $sql = "Update role set title=:title,description=:description where id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }

        public function Getpermissions(){
            $sql = "Select * from role where deleted=false";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function permissions(){
            $sql = "Update role set permissions=:permission where id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':permission', $this->permission);
            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }
    }

?>