<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PATCH');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/db.php");
    include_once("../../model/products.php");

    $db = new db();
    $connect = $db->connect();

    $Product = new Product($connect);
    $Product->id = isset($_GET['id']) ? $_GET['id'] : die();

    $data = json_decode(file_get_contents("php://input"));
    $Product->status = $data->status;

    if($Product->changeStatus()){
        echo json_encode(array('message','Success'));
    }else{
        echo json_encode(array('message','Error'));
    }

?>