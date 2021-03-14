<?php
    session_start();
    include "./models/db.php";

    $userId = $_SESSION["USER_ID"];

    $db = new DB();

    $partOfName = $_GET["name"];

    $result = $db->plants_search($userId, $partOfName);

    echo json_encode($result);

?>
