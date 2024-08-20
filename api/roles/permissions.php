<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PATCH');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/db.php");
    include_once("../../model/roles.php");

    $db = new db();
    $connect = $db->connect();

    $Role = new Role($connect);

    $data = json_decode(file_get_contents("php://input"));

    foreach($data as $item){
        $Role->id = $item->id;
        $Role->permission = implode(",",$item->permission);
        if($Role->permissions()){
            echo json_encode(array('message','Success'));
        }else{
            echo json_encode(array('message','Error'));
        }
    }

    
    

?>