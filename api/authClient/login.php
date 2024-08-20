<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/db.php");
    include_once("../../model/user.php");

    $db = new db();
    $connect = $db->connect();

    $user = new user($connect);

    $data = json_decode(file_get_contents("php://input"));
    $user->email = $data->email;
    $user->password = $data->password;
    
    if($user->login()){
        $read = $user->login();
        $user = array(
            "tokenUser" => $read['tokenUser'],
            'fullname' => $read['fullname'],
            'email' => $read['email'],
            'username' => $read['username'],
        );
        echo json_encode(array("message" => "Success","info" => $user));
    }else{
        echo json_encode(array("message" => "error"));
    }

?>