<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once("../../config/db.php");
    include_once("../../model/roles.php");

    $db = new db();
    $connect = $db->connect();

    $Role = new Role($connect);
    $Role->id = isset($_GET['id']) ? $_GET['id'] : die();
    $Role->detail();

    $role_item = array(
        'id' => $Role->id,
        'title' => $Role->title,
        'description' => $Role->description
    );

    echo json_encode($role_item);
?>