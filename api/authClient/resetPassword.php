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

    $User->password = md5($data->password);
    $User->tokenUser = $data->tokenUser;

    if($User->resetPassword()){
        echo json_encode(array("message" => "Success"));
    }else{
        echo json_encode(array("message" => "Error"));
    }

?>