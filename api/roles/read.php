<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');

    include_once("../../config/db.php");
    include_once("../../model/roles.php");

    $db = new db();
    $connect = $db->connect();

    $Role = new Role($connect);
    $read = $Role->read();

    $num = $read->rowCount();
    if($num > 0){
        $role_array = [];
        // $question_array['data'] = [];

        while($row = $read->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $role_item = array(
                "id" => $id,
                'title' => $title,
                'description' => $description,
                'permissions' => $permissions
            );
            array_push($role_array, $role_item);
        }

        echo json_encode($role_array);
    }
?>