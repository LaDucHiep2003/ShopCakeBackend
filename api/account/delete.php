<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PATCH');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/db.php");
    include_once("../../model/account.php");

    $db = new db();
    $connect = $db->connect();

    $Account = new Account($connect);

    $data = json_decode(file_get_contents("php://input"));
    $Account->id = $data->id;

    if($Account->delete()){
        echo json_encode(array('message','Success'));
    }else{
        echo json_encode(array('message','Error'));
    }
?>