<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PATCH');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/db.php");
    include_once("../../model/checkout.php");

    $db = new db();
    $connect = $db->connect();

    $Checkout = new Checkout($connect);

    $data = json_decode(file_get_contents("php://input"));
    $Checkout->id = $data->id;


    if($Checkout->comfirmOrder()){
        echo json_encode(array('message','Success'));
    }else{
        echo json_encode(array('message','Error'));
    }

?>