<?php
    session_start();

    include "./models/db.php";

    $userId = $_SESSION["USER_ID"];
    $action = $_GET["action"];

    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if ($contentType === "application/json") {
        $content = trim(file_get_contents("php://input"));
        $obj = json_decode($content, true);

        $db = new DB();

        $plantId = $obj["plantId"];

        if($action === "addToCart"){
            $result = $db->add_to_cart($userId, $plantId, 1);
        }else if($action === "openSession"){
            $_SESSION["PLANT_ID"] = $plantId;
            $result = json_encode(Array("error"=>false));
        }else{
            $result = $db->add_to_liked($userId, $plantId);
        }
        if($result){
            $encoded = json_encode(Array("error"=>false));
        }else{
            $encoded = json_encode(Array("error"=>true));
        }
        echo $encoded;
    }
?>