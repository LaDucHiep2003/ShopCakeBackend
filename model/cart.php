<?php
    class Cart{
        private $conn;

        public $id;
        public $title;
        public $email;
        public $image;
        public $quantity;
        public $cartId;
        public $totalCart;
        public $totalPrice;
        public $product_id;

        public function __construct($db){
            $this->conn = $db;
        }

        public function addCart(){
            $sql = "INSERT INTO carts(user_id) VALUES(null)";
            $stmt = $this->conn->prepare($sql);
            if ($stmt->execute()) {
                $lastInsertId = $this->conn->lastInsertId();
        
                $sql = "SELECT * FROM carts WHERE id = :id";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':id', $lastInsertId);
                $stmt->execute();
        
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            print($stmt->errorInfo());
            return false;
        }

        public function addProduct(){
            $sql = "SELECT * FROM cart_items WHERE cart_id=:cart_id AND product_id=:product_id";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':cart_id', $this->cartId);
            $stmt->bindParam(':product_id', $this->product_id);

            $stmt->execute();
            $num = $stmt->rowCount();

            if($num > 0){
                $sql = "UPDATE cart_items SET quantity=:quantity WHERE cart_id=:cart_id AND product_id=:product_id";
            } else {
                $sql = "INSERT INTO cart_items(cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)";
            }

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':cart_id', $this->cartId);
            $stmt->bindParam(':product_id', $this->product_id);
            $stmt->bindParam(':quantity', $this->quantity);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }

        public function detail(){
            $sql = "SELECT products.id, products.title, products.price, products.image,products.thumbnail, cart_items.quantity FROM products
                    INNER JOIN cart_items on products.id = cart_items.product_id
                    INNER JOIN carts on cart_items.cart_id = carts.id
                    WHERE carts.id=:cart_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':cart_id', $this->cartId);

            $stmt->execute();
            return $stmt;
        }

        public function changeQuantity() {
            $sql = "UPDATE cart_items set quantity=:quantity WHERE product_id=:product_id AND cart_id=:cart_id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':product_id', $this->product_id);
            $stmt->bindParam(':quantity', $this->quantity);
            $stmt->bindParam(':cart_id', $this->cartId);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }

        public function detailProduct(){
            $sql = "SELECT products.id, products.title,products.description, products.price, products.image, cart_items.quantity FROM products
                    INNER JOIN cart_items on products.id = cart_items.product_id
                    INNER JOIN carts on cart_items.cart_id = carts.id
                    WHERE carts.id=:cartId AND products.id=:product_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':cartId', $this->cartId);
            $stmt->bindParam(':product_id', $this->product_id);

            $stmt->execute();
            return $stmt;
        }

        public function deleteCart(){
            $sql = "DELETE FROM cart_items WHERE product_id=:product_id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':product_id', $this->product_id);

            $stmt->execute();
            return $stmt;
        }


    }

?>