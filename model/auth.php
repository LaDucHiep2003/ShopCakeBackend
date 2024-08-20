<?php
    class Auth{
        private $conn;

        public $id;
        public $fullName;
        public $email;
        public $password;
        public $token;
        public $phone;
        public $avatar;
        public $roleId;
        public $status;

        public function __construct($db){
            $this->conn = $db;
        }

        public function login() {
            $sql = "SELECT * FROM accounts WHERE email=:email";
            $stmt = $this->conn->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':email', $this->email);
                    

            if( $stmt->execute()){
                $account = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($account && md5($this->password) === $account['password']) {
                    return $account;
                } else {
                    return false;
                }
            }else{
                print($stmt->errorInfo());
                 return false;
            }
            
        
        }
    
    }
?>