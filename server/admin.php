<?php
    session_start();
    include "./models/db.php";

    $db = new DB();

    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if ($contentType === "application/json") {
        $content = trim(file_get_contents("php://input"));
        $obj = json_decode($content, true);

        if($_GET["action"] === "addNewPlant"){
            if($db->add_new_plant($obj["name"], $obj["type"], $obj["color"], $obj["price"], $obj["height"], $obj["rating"], $obj["desc"], $obj["url"])){
                $result = Array("ok" => true);
            }else{
                $result = Array("ok" => false);
            }
        }elseif($_GET["action"] === "addNewBlog"){
            if($db->add_new_blog($obj["title"], $obj["preview"], $obj["text"], $obj["url"])){
                $result = Array("ok" => true);
            }else{
                $result = Array("ok" => false);
            }
        }elseif($_GET["action"] === "removePlant"){
            if($db->remove_plant_global($obj["plantId"])){
                $result = Array("ok" => true);
            }else{
                $result = Array("ok" => false);
            }
        }else{
            if($db->remove_blog_global($obj["blogId"])){
                $result = Array("ok" => true);
            }else{
                $result = Array("ok" => false);
            }
        }
        echo json_encode($result);
    }
?>
