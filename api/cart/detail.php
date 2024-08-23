<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once("../../config/db.php");
    include_once("../../model/cart.php");

    $db = new db();
    $connect = $db->connect();

    $Cart = new Cart($connect);
    $Cart->cartId = isset($_GET['cartId']) ? $_GET['cartId'] : die();

    $read = $Cart->detail();
    $num = $read->rowCount();
    if($num > 0){
        $product_array = [];
        $product_array['data'] = [];
        $product_array['quantity'] = 0;
        $product_array['totalPrice'] = 0;
        $totalCart = 0;
        $totalPrice = 0;
        while($row = $read->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $totalCart += $row['quantity'];
            $totalPrice += $row['price'] * $row['quantity'];

            $product_item = array(
                "id" => $row['id'],
                'title' => $row['title'],
                'price' => $row['price'],
                'image' => $row['image'],
                'thumbnail' => $row['thumbnail'],
                'quantity' => $row['quantity'],
                'totalPrice' => $row['price'] * $row['quantity'],
            );
            array_push($product_array['data'], $product_item);
        }
        $product_array['quantity'] = $totalCart;
        $product_array['totalPrice'] = $totalPrice;

        echo json_encode($product_array);
    }else{
        echo json_encode(array('message','Emply'));
    }
    
?>