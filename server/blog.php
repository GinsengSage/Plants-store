<?php
    session_start();
    include "./models/db.php";
    $userId = $_SESSION["USER_ID"];

    $db = new DB();

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $result = $db->get_blogs();
        echo json_encode($result);
    }else {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $obj = json_decode($content, true);

            $_SESSION["BLOG_ID"] = $obj["blogId"];
            echo json_encode(Array("ok" => true));
        }
    }

