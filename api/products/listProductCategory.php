<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once("../../config/db.php");
    include_once("../../model/products.php");

    $db = new db();
    $connect = $db->connect();

    $Product = new Product($connect);

    $Product->category_id = isset($_GET['id']) ? $_GET['id'] : die();
    $read = $Product->listProductCategory();

    $num = $read->rowCount();
    if($num > 0){
        $product_array = [];
        while($row = $read->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $product_item = array(
                "id" => $id,
                'title' => $title,
                'price' => $price,
                'thumbnail' => $thumbnail,
                'oldPrice' => $oldPrice
            );
            array_push($product_array, $product_item);
        }
    }
    echo json_encode($product_array);
?>