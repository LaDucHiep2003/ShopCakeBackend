<?php
    class Account{
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
        public $permissions;

        public function __construct($db){
            $this->conn = $db;
        }

        public function read(){
            $sql = "Select * from accounts where deleted=false";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt;
        }

        // public function readRoles($accountId) {
        //     // Query to join role and accounts tables based on accountId
        //     $sql = "SELECT * FROM role
        //              INNER JOIN accounts ON role.id = accounts.roleId
        //              WHERE accounts.id = :id";
        //     $stmt = $this->conn->prepare($sql);
        //     $stmt->bindParam(':id', $this->id);
        //     $stmt->execute();
        //     return $stmt;
        // }

        public function create(){
            $sql = "Insert Into accounts (fullName, email, password, token, phone, avatar, roleId, status) 
            VALUES (:fullName, :email, :password, :token, :phone, :avatar, :roleId, :status)";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':fullName', $this->fullName);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':token', $this->token);
            $stmt->bindParam(':phone', $this->phone);
            $stmt->bindParam(':status', $this->status);
            $stmt->bindParam(':avatar', $this->avatar);
            $stmt->bindParam(':roleId', $this->roleId);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }

        public function delete(){
            $sql = "Update accounts set deleted=true where id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
           
            return false;
        }

        public function changeStatus(){
            $sql = "Update accounts set status=:status where id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':status', $this->status);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }

        public function infoUser(){
            $sql = "SELECT accounts.id,accounts.fullName, accounts.email,accounts.phone, accounts.avatar, role.permissions FROM `accounts`
                INNER JOIN role on accounts.roleId = role.id
                WHERE accounts.token=:token";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':token', $this->token);
            $stmt->execute();

            return $stmt;
        }

        public function detail(){
            
            $sql = "Select * from accounts where id=:id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);

            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->id = $row['id'];
            $this->fullName = $row['fullName'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->phone = $row['phone'];
            $this->avatar = $row['avatar'];
            $this->status = $row['status'];
            $this->roleId = $row['roleId'];
        }

        public function edit(){
            $sql = "Update accounts set fullName=:fullName,password=:password, phone=:phone, avatar=:avatar, roleId=:roleId, status=:status, email=:email
            where id=:id";
            
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':id', $this->id);
            $stmt->bindParam(':fullName', $this->fullName);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':phone', $this->phone);
            $stmt->bindParam(':avatar', $this->avatar);
            $stmt->bindParam(':roleId', $this->roleId);
            $stmt->bindParam(':status', $this->status);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }

    }

?>