<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/db.php");
    include_once("../../model/cart.php");

    $db = new db();
    $connect = $db->connect();

    $Cart = new Cart($connect);

    $data = json_decode(file_get_contents("php://input"));
    $Cart->cartId = $data->cartId;
    $Cart->product_id = $data->product_id;
    $Cart->quantity = $data->quantity;


    if($Cart->addProduct()){
        echo json_encode(array('message','Success'));
    }else{
        echo json_encode(array('message','Error'));
    }

?>