
<?php
    class Product{
        private $conn;

        public $id;
        public $title;
        public $description;
        public $price;
        public $image;
        public $position;
        public $status;
        public $deleted;
        public $oldPrice;
        public $sort;
        public $value;
        public $parentId;
        public $cartId;
        public $product_id;

        public function __construct($db){
            $this->conn = $db;
        }

        public function read(){
            $sort = isset($_GET['sort']) ? $_GET['sort'] : "position";
            $value = isset($_GET['value']) ? $_GET['value'] : "desc";
            $limit = isset($_GET['limit']) ? $_GET['limit'] : 2;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;

            $offset = ($page - 1) * $limit;

            $sql = "SELECT * FROM products WHERE deleted=false ORDER BY $sort $value LIMIT :limit OFFSET :offset";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;
        }
        public function deleted(){
            $sort = isset($_GET['sort']) ? $_GET['sort'] : "position";
            $value = isset($_GET['value']) ? $_GET['value'] : "desc";
            $limit = isset($_GET['limit']) ? $_GET['limit'] : 2;
            $page = isset($_GET['page']) ? $_GET['page'] : 1;

            $offset = ($page - 1) * $limit;

            $sql = "SELECT * FROM products WHERE deleted=true ORDER BY $sort $value LIMIT :limit OFFSET :offset";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt;
        }
        public function count() {
            $sql = "SELECT COUNT(*) as total FROM products WHERE deleted=false";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'];
        }
        public function countDeleted() {
            $sql = "SELECT COUNT(*) as total FROM products WHERE deleted=true";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['total'];
        }

        public function create(){
            $sql = "Insert Into products (title, description, price, image, position, status, oldPrice, parentId) 
            VALUES (:title, :description, :price, :image, :position, :status, :oldPrice, :parentId)";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':position', $this->position);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':oldPrice', $this->oldPrice);
            $stmt->bindParam(':parentId', $this->parentId);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }

        public function delete(){
            $sql = "Update products set deleted=true where id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
           
            return false;
        }

        public function restore(){
            $sql = "Update products set deleted=false where id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
           
            return false;
        }

        public function permanently_deleted(){
            $sql = "DELETE FROM products WHERE id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
           
            return false;
        }

        public function detail(){
            
            $sql = "Select * from products where id=:id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $row['id'];
            $this->title = $row['title'];
            $this->description = $row['description'];
            $this->price = $row['price'];
            $this->position = $row['position'];
            $this->oldPrice = $row['oldPrice'];
            $this->status = $row['status'];
            $this->image = $row['image'];

        }

        public function update(){
            $sql = "Update products set title=:title,description=:description, price=:price, image=:image, position=:position, status=:status, oldPrice=:oldPrice
            where id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':image', $this->image);
            $stmt->bindParam(':position', $this->position);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':oldPrice', $this->oldPrice);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }

        public function changeStatus(){
            $sql = "Update products set status=:status where id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':status', $this->status);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }


    }

?>