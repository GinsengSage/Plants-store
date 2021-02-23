<?php
        session_start();
        include "./models/db.php";

        $userId = $_SESSION["USER_ID"];

        $db = new DB();
        $plants = $db->get_plants($userId);

        if($plants){
            $result = Array("error" => false, "plants" => $plants, "userId" => $userId);
        }else{
            $result = Array("error" => true);
        }

        $encoded = json_encode($result);
        echo $encoded;
?>
