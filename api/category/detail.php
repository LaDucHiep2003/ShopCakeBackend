<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once("../../config/db.php");
    include_once("../../model/category.php");

    $db = new db();
    $connect = $db->connect();

    $Category = new Category($connect);
    $Category->id = isset($_GET['id']) ? $_GET['id'] : die();
    $Category->detail();

    $item = array(
        'title' => $Category->title,
        'position' => $Category->position,
        'parentId' => $Category->parentId,
        'status' => $Category->status,
        'description' => $Category->description
    );

    echo json_encode($item);
?>