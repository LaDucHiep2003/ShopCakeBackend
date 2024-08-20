<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once("../../config/db.php");
    include_once("../../model/account.php");

    $db = new db();
    $connect = $db->connect();

    $Account = new Account($connect);
    $read = $Account->read();

    $num = $read->rowCount();
    if($num > 0){
        $role_array = [];
        // $question_array['data'] = [];

        while($row = $read->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $role_item = array(
                "id" => $id,
                'fullName' => $fullName,
                'email' => $email,
                'status' => $status
            );
            array_push($role_array, $role_item);
        }

        echo json_encode($role_array);
    }
?>