<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once("../../config/db.php");
    include_once("../../model/category.php");

    $db = new db();
    $connect = $db->connect();

    $Category = new Category($connect);
    $read = $Category->read();

    $num = $read->rowCount();
    if($num > 0){
        $product_array = [];
        // $question_array['data'] = [];

        while($row = $read->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $product_item = array(
                "id" => $id,
                'title' => $title,
                'position' => $position,
                'status' => $status,
            );
            array_push($product_array, $product_item);
        }

        echo json_encode($product_array);
    }
?>