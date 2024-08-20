<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
    
    include_once("../../config/db.php");
    include_once("../../model/category.php");

    $db = new db();
    $connect = $db->connect();

    $Category = new Category($connect);

    $data = json_decode(file_get_contents("php://input"));
    $Category->title = $data->title;
    $Category->description = $data->description;
    $Category->status = $data->status;
    $Category->position = $data->position;
    $Category->parentId = $data->parentId;

    if($Category->create()){
        echo json_encode(array('message','Success'));
    }else{
        echo json_encode(array('message','Error'));
    }

?>