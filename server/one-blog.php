<?php
    session_start();
    include "./models/db.php";
    $userId = $_SESSION["USER_ID"];
    $blogId = $_SESSION["BLOG_ID"];

    $db = new DB();
    $action = $_GET["action"];

    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        if($action === 'getBlog'){
            $result = $db->get_blog($_SESSION["BLOG_ID"]);
        }else{
            $result = $db->get_comments($_SESSION["BLOG_ID"]);
        }
        echo json_encode($result);
    }else {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $obj = json_decode($content, true);

            $text = $obj["text"];

            $result = $db->insert_comment($userId, $blogId, $text);
            if($result)
                $result = Array("ok" => true);
            else
                $result = Array("ok" => false);
            return json_encode($result);
        }
    }

?>