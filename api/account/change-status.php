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
    $Account->id = isset($_GET['id']) ? $_GET['id'] : die();

    $data = json_decode(file_get_contents("php://input"));
    $Account->status = $data->status;

    if($Account->changeStatus()){
        echo json_encode(array('message','Success'));
    }else{
        echo json_encode(array('message','Error'));
    }

?>