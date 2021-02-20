<?php
    session_start();

    include "./models/db.php";
    include "./models/user.php";

    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
    if ($contentType === "application/json") {
        $content = trim(file_get_contents("php://input"));
        $obj = json_decode($content, true);

        $db = new DB();

        if(!($db->has_user($obj["email"]))){
            $user = new User($obj["name"], $obj["login"], $obj["email"], $obj["address"], $obj["password"]);

            $result = $db->insert_user($user);
            if($result)
                $_SESSION["USER_ID"] = $result["Id"];
            else{
                $result = Array("error" => true, "message" => "Some system error");
            }
        }else{
            $result = Array("error" => true, "message" => "User with this email is exist");
        }

        $encoded = json_encode($result);
        echo $encoded;
    }
?>
