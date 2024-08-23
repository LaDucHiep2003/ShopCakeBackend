<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/db.php");
    include_once("../../model/checkout.php");

    $db = new db();
    $connect = $db->connect();

    $Checkout = new Checkout($connect);

    $data = $Checkout->checkout();
    $data = json_decode(file_get_contents("php://input"));
    $Checkout->cartId = $data['delivery']['cartId'];
    if($data){
        echo json_encode($data);
    }else{
        echo json_encode(array('message','Error'));
    }

?>