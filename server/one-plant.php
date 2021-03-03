<?php
    session_start();

    include "./models/db.php";

    $db = new DB();

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $result = $db->get_plant($_SESSION["USER_ID"],$_SESSION["PLANT_ID"]);
        echo json_encode($result);
    }else{
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $obj = json_decode($content, true);

            if($_GET["action"] === "addToLiked"){
                $result = $db->add_to_liked($_SESSION["USER_ID"], $_SESSION["PLANT_ID"]);
            }else{
                $result = $db->add_to_cart($_SESSION["USER_ID"], $_SESSION["PLANT_ID"], 1);
            }

            $encoded = json_encode($result);
            echo $encoded;
        }
    }

?>
