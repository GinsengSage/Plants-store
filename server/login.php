<?php
    session_start();

    include "./models/db.php";

    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if ($contentType === "application/json") {
        $content = trim(file_get_contents("php://input"));
        $obj = json_decode($content, true);

        $login = $obj["login"];
        $password = $obj["password"];

        $db = new DB();
        $result = $db->user_login($login, $password);
        if($result["error"] === false)
            $_SESSION["USER_ID"] = $result["Id"];

        $encoded = json_encode($result);
        echo $encoded;
    }
?>