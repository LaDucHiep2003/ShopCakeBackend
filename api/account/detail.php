<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once("../../config/db.php");
    include_once("../../model/account.php");

    $db = new db();
    $connect = $db->connect();

    $Account = new Account($connect);
    $Account->id = isset($_GET['id']) ? $_GET['id'] : die();
    $Account->detail();

    $item = array(
        'fullName' => $Account->fullName,
        'email' => $Account->email,
        'password' => $Account->password,
        'status' => $Account->status,
        'roleId' => $Account->roleId,
        'phone' => $Account->phone,
        'avatar' => $Account->avatar
    );

    echo json_encode($item);
?>