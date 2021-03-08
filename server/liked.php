<?php
    session_start();
    include "./models/db.php";
    $userId = $_SESSION["USER_ID"];

    $db = new DB();

    if($_SERVER['REQUEST_METHOD'] == 'GET'){

        if($_GET["action"] === "getPersonalInfo"){
            $result = $db->get_personalInfo($userId);
        }else{
            $result = $db->get_likedPlants($userId);
        }
        echo json_encode($result);
    }else {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $plantId = json_decode($content, true)["plantId"];

            if($db->remove_from_liked($plantId, $userId)){
                $result = Array("ok" => true);
            }else{
                $result = Array("ok" => false);
            }
            echo json_encode($result);
        }
    }
?>
