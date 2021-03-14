<?php

    include "./models/email-sender.php";

    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if ($contentType === "application/json") {
        $content = trim(file_get_contents("php://input"));
        $obj = json_decode($content, true);
        
        $name = $obj["name"];
        $email = $obj["email"];
        $phone = $obj["phone"];
        $subject = $obj["subject"];
        $message = $obj["message"];

        $emailSender = new EmailSender();
        $sended = $emailSender->sendMessage($name, $email, $phone, $subject, $message);
        if($sended){
            echo json_encode(Array("ok" => true));
        }else{
            echo json_encode(Array("ok" => false));
        }
    }

?>