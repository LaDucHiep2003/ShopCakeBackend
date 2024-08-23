<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once("../../config/db.php");
    include_once("../../model/checkout.php");

    $db = new db();
    $connect = $db->connect();

    $Checkout = new Checkout($connect);
    $read = $Checkout->confirmed();

    $num = $read->rowCount();
    if($num > 0){
        $data_array = [];

        while($row = $read->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $data = array(
                "id" => $id,
                'lastName' => $last_name,
                'firstName' => $first_name,
                'totalPrice' => $totalPrice,
                'totalQuantity' => $totalQuantity,
                'phone' => $phone,
                'address' => $address,
            );
            array_push($data_array, $data);
        }

        echo json_encode($data_array);
    }
?>