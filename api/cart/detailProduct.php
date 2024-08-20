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

    $Cart->product_id = isset($_GET['id']) ? $_GET['id'] : die();

    $data = json_decode(file_get_contents("php://input"));
    $Cart->cartId = $data->cartId;

    $read = $Cart->addProduct();
    
    if($read){
        $user = array(
            "id" => $read['token']
        );
        echo json_encode(array("message" => "Success","info" => $user));
    }else{
        echo json_encode(array("message" => "error"));
    }

?>