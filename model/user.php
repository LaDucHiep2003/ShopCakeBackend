<?php
    class user{
        private $conn;

        public $fullname;
        public $email;
        public $password;
        public $address;
        public $username;
        public $tokenUser;
        public $otp;

        public function __construct($db){
            $this->conn = $db;
        }

        public function register(){
            $sql = "SELECT * FROM users WHERE email = :email";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':email', $this->email);
            $stmt->execute();
            
            if ($stmt->fetchColumn() > 0) {
                // echo json_encode(array('message','Tài khoản đã tồn tại'));
                return false;
            }

            $sql = "INSERT INTO users(email, password, username, fullname, tokenUser) VALUES(:email,:password,:username,:fullname,:tokenUser)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':fullname', $this->fullname);
            $stmt->bindParam(':tokenUser', $this->tokenUser);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }

        public function login() {
            $sql = "SELECT * FROM users WHERE email=:email";
            $stmt = $this->conn->prepare($sql);

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

        public function detail(){
            $sql = "Select * from users where tokenUser=:tokenUser";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':tokenUser', $this->tokenUser);

            $stmt->execute();

            return $stmt;
        }

        public function forgotPassword(){
            $sql = "SELECT * FROM forgotpassword 
                    INNER JOIN users on forgotpassword.email = users.email
                    WHERE forgotpassword.email=:email";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $this->email);

            $stmt->execute();
            $num = $stmt->rowCount();
            if($num > 0){
                return false;
            }else{
                $sql = "SELECT * FROM users WHERE email=:email";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':email', $this->email);

                $stmt->execute();
                $num = $stmt->rowCount();
                if($num < 1){
                    return false;
                }
            }

            $sql = "INSERT INTO forgotpassword(email, otp) VALUES (:email, :otp)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':otp', $this->otp);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }

        public function otpPassword(){
            $sql = "SELECT * FROM forgotpassword WHERE email=:email AND otp=:otp";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':otp', $this->otp);

            $stmt->execute();
            $num = $stmt->rowCount();
            if($num > 0){
                $sql = "SELECT tokenUser FROM users
                        INNER JOIN forgotpassword on users.email = forgotpassword.email
                        WHERE users.email=:email";

                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':email', $this->email);
                $stmt->execute();

                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                if($data){
                    return $data;
                }
                return false;
            }
            return false;
        }

        public function resetPassword(){
            $sql = "Update users set password=:password where tokenUser=:tokenUser";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':tokenUser', $this->tokenUser);

            if( $stmt->execute()){
                return true;
            }
            print($stmt->errorInfo());
            return false;
        }
    }

?>