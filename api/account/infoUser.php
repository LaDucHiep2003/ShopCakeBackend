<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/db.php");
    include_once("../../model/account.php");

    $db = new db();
    $connect = $db->connect();

    $Account = new Account($connect);
    $data = json_decode(file_get_contents("php://input"));
    $Account->token = $data->token;

    $stmt = $Account->infoUser();
    if ($stmt->rowCount() > 0) {
        $read = $stmt->fetch(PDO::FETCH_ASSOC);
        $user = array(
            "id" => $read['id'],
            'fullName' => $read['fullName'],
            'email' => $read['email'],
            'phone' => $read['phone'],
            'avatar' => $read['avatar'],
            "permissions" => $read['permissions']
        );
        echo json_encode($user);
    } else {
        echo json_encode(array("message" => "error"));
    }
?>