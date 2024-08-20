<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once("../../config/db.php");
    include_once("../../model/user.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'lahiep2k3@gmail.com';
    $mail->Password = 'nnowhdwpsjxocwhp';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('lahiep2k3@gmail.com');

    $db = new db();
    $connect = $db->connect();

    $user = new user($connect);

    $data = json_decode(file_get_contents("php://input"));

    $otp = "0123456789";
    for($i = 0;$i < 8;$i++){
        $user->otp.= $otp[rand(0, strlen($otp) - 1)];
    }
    $mail->isHTML(true);

    $mail->Subject = "Code";
    $mail->Body = $user->otp;
    $mail->addAddress($data->email);

    $user->email = $data->email;

    if($user->forgotPassword()){
        $mail->send();
        echo json_encode(array("message" => "Success"));
    }else{
        echo json_encode(array("message" => "Error"));
    }

?>