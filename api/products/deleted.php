<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once("../../config/db.php");
    include_once("../../model/products.php");

    $db = new db();
    $connect = $db->connect();

    $Product = new Product($connect);
    $read = $Product->deleted();

    $num = $read->rowCount();
    $totalItems = $Product->countDeleted();
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 2;
    $totalPages = ceil($totalItems / $limit);
    if($num > 0){
        $product_array = [];
        while($row = $read->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $product_item = array(
                "id" => $id,
                'title' => $title,
                'position' => $position,
                'price' => $price,
                'status' => $status,
                'image' => $image,
                'oldPrice' => $oldPrice
            );
            array_push($product_array, $product_item);
        }

        echo json_encode([
            "totalPages" => $totalPages,
            "products" => $product_array
        ]);
    }
?>