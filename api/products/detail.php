<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once("../../config/db.php");
    include_once("../../model/products.php");

    $db = new db();
    $connect = $db->connect();

    $Product = new Product($connect);
    $Product->id = isset($_GET['id']) ? $_GET['id'] : die();
    $Product->detail();

    $product_item = array(
        'id' => $Product->id,
        'title' => $Product->title,
        'position' => $Product->position,
        'price' => $Product->price,
        'status' => $Product->status,
        'image' => $Product->image,
        'oldPrice' => $Product->oldPrice,
        'description' => $Product->description
    );

    echo json_encode($product_item);
?>