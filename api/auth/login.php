<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/db.php");
    include_once("../../model/auth.php");

    $db = new db();
    $connect = $db->connect();

    $Auth = new Auth($connect);

    $data = json_decode(file_get_contents("php://input"));
    $Auth->email = $data->email;
    $Auth->password = $data->password;
    
    if($Auth->login()){
        $read = $Auth->login();
        $user = array(
            "token" => $read['token'],
            'fullName' => $read['fullName'],
            'email' => $read['email'],
            'phone' => $read['phone'],
            'avatar' => $read['avatar']
        );
        echo json_encode(array("message" => "Success","info" => $user));
    }else{
        echo json_encode(array("message" => "error"));
    }

?>