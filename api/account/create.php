<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/db.php");
    include_once("../../model/account.php");

    $db = new db();
    $connect = $db->connect();

    $Account = new Account($connect);

    $data = json_decode(file_get_contents("php://input"));

    $characters = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789";
    for($i = 0;$i < 20;$i++){
        $Account->token.= $characters[rand(0, strlen($characters) - 1)];
    }
    $Account->fullName = $data->fullName;
    $Account->email = $data->email;
    $Account->password = md5($data->password);
    $Account->phone = $data->phone;
    $Account->status = $data->status;
    $Account->avatar = $data->avatar;
    $Account->roleId = $data->roleId;

    if($Account->create()){
        echo json_encode(array('message','Success'));
    }else{
        echo json_encode(array('message','Error'));
    }

?>