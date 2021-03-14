<?php
    session_start();
    include "./models/db.php";
    include"./models/email-sender.php";
    $userId = $_SESSION["USER_ID"];

    $db = new DB();

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $result = $db->get_cartPlants($userId);
        echo json_encode($result);
    }else {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));

            $obj = json_decode($content, true);

            $action = $_GET["action"];

            if($action === "removePlant"){
                if($db->remove_from_cart($obj["plantId"], $userId)){
                    $result = Array("ok" => true);
                }else{
                    $result = Array("ok" => false);
                }
            }elseif($action === "cleanCart"){
                if($db->clean_cart($userId)){
                    $result = Array("ok" => true);
                }else{
                    $result = Array("ok" => false);
                }
            }else{
                
                $name = $obj["name"];
                $email = $obj["email"];
                $address = $obj["address"];
                $sum = $obj["sum"];

                $plantsList = $obj["plantsList"];

                $email_sender = new EmailSender();
                if($email_sender.sendOrder($plantsList, $sum, $name, $email, $address)){
                    echo "Your message was sended!";
                }else{
                    echo "Error, try again!";
                }
        
            }
            echo json_encode($result);
        }
    }
?>
