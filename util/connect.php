<?php
    $host = "localhost";
    $user = "weds159";
    $password = "tjdus159^^";

    $db = "weds159";

    $connect = new mysqli($host, $user, $password, $db);
    $connect -> set_charset("utf-8");
    
    if($connect->connect_error){
        echo "Connect Failed" . $connect->connect_error;
    }
?>