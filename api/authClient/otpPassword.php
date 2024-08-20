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

    $User->email = $data->email;
    $User->otp = $data->otp;

    if($User->otpPassword()){
        $read = $User->otpPassword();
        $tokenUser = $read['tokenUser'];
        echo json_encode(array("message" => "Success","tokenUser" => $tokenUser));
    }else{
        echo json_encode(array("message" => "error"));
    }

?>