<?php
    $host = "localhost";
    $user = "spearboy";
    $password = "whqudgus0708!";

    $db = "spearboy";

    $connect = new mysqli($host, $user, $password, $db);
    $connect -> set_charset("utf-8");
    
    if($connect->connect_error){
        echo "Connect Failed" . $connect->connect_error;
    }
?>