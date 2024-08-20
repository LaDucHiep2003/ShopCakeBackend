
<?php
    class Checkout{
        private $conn;

        public $id;
        public $first_name;
        public $last_name;
        public $city;
        public $address;
        public $company;
        public $phone;
        public $cartId;
        public $product_id;

        public function __construct($db){
            $this->conn = $db;
        }

        public function checkout(){
            $sql = "Insert Into orders(cart_id, first_name, last_name, company, city, phone, address) 
                Values(:cart_id, :first_name, :last_name, :company, :city, :phone, :address)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':cart_id', $this->cartId);
            $stmt->bindParam(':first_name', $this->first_name);
            $stmt->bindParam(':last_name', $this->last_name);
            $stmt->bindParam(':company', $this->company);
            $stmt->bindParam(':city', $this->city);
            $stmt->bindParam(':phone', $this->phone);
            $stmt->bindParam(':address', $this->address);
        }

    }


?>