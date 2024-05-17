<?php
    $host = "localhost";
    $user = "rlagusals235";
    $password = "qkql0219!";

    $db = "rlagusals235";

    $connect = new mysqli($host, $user, $password, $db);
    $connect -> set_charset("utf-8");
    
    if($connect->connect_error){
        echo "Connect Failed" . $connect->connect_error;
    }
?>