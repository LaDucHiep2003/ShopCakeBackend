<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/db.php");
    include_once("../../model/user.php");

    $db = new db();
    $connect = $db->connect();

    $User = new user($connect);

    $data = json_decode(file_get_contents("php://input"));

    $characters = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789";
    for($i = 0;$i < 20;$i++){
        $User->tokenUser.= $characters[rand(0, strlen($characters) - 1)];
    }
    $User->email = $data->email;
    $User->password = md5($data->password);
    $User->username = $data->username;
    $User->fullname = $data->fullname;

    if($User->register()){
        echo json_encode(array("message" => "Success","info" => $User));
    }else{
        echo json_encode(array("message" => "Error"));
    }

?>