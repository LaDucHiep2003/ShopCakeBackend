<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/db.php");
    include_once("../../model/user.php");

    $db = new db();
    $connect = $db->connect();

    $user = new user($connect);
    $data = json_decode(file_get_contents("php://input"));
    $user->tokenUser = $data->tokenUser;

    $stmt = $user->detail();
    if ($stmt->rowCount() > 0) {
        $read = $stmt->fetch(PDO::FETCH_ASSOC);
        $data = array(
            "id" => $read['id'],
            'fullname' => $read['fullname'],
            'email' => $read['email'],
            'username' => $read['username'],
        );
        echo json_encode($data);
    } else {
        echo json_encode(array("message" => "error"));
    }
?>