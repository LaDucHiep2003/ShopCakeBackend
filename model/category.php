<?php
    class Category{
        private $conn;

        public $id;
        public $title;
        public $description;
        public $position;
        public $status;
        public $deleted;
        public $parentId;
        public $sort;
        public $value;

        public function __construct($db){
            $this->conn = $db;
        }

        public function read(){
            $sort = isset($_GET['sort']) ? $_GET['sort'] : "position";
            $value = isset($_GET['value']) ? $_GET['value'] : "desc";
            $sql = "Select * from category where deleted=false ORDER BY $sort $value";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        public function delete(){
            $sql = "Update category set deleted=true where id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
           
            return false;
        }

        public function changeStatus(){
            $sql = "Update category set status=:status where id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':status', $this->status);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }
        public function create(){
            $sql = "Insert Into category (title, description, position, status, parentId) 
            VALUES (:title, :description, :position, :status, :parentId)";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':position', $this->position);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':parentId', $this->parentId);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }

        public function detail(){
            
            $sql = "Select * from category where id=:id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $row['id'];
            $this->title = $row['title'];
            $this->parentId = $row['parentId'];
            $this->description = $row['description'];
            $this->position = $row['position'];
            $this->status = $row['status'];
        }

        public function edit(){
            $sql = "Update category set title=:title,description=:description, parentId=:parentId, position=:position, status=:status
            where id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':parentId', $this->parentId);
            $stmt->bindParam(':position', $this->position);
            $stmt->bindParam(':status', $this->status);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }
    }

?>