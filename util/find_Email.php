<?php
    include "./connect.php";
    include "./session.php";

    $userName = mysqli_real_escape_string($connect, $_POST['userName']);
    $userPhone = mysqli_real_escape_string($connect, $_POST['userPhone']);

    $sql = "SELECT userEmail, userName, userPhone FROM pickstomuser WHERE userName = '$userName' AND userPhone = '$userPhone'";
    $result = $connect->query($sql);

    $jsonResult = "";
    $emails = array();

    if($result){
        $count = $result->num_rows;
        if($count == 0) {
            $jsonResult = "not_found";
        } else {
            $jsonResult = "success";
            while($userInfo = $result->fetch_assoc()) {
                $emails[] = $userInfo['userEmail'];
            }
        }
    } else {
        $jsonResult = "error";
    }

    echo json_encode(array("result" => $jsonResult, "emails" => $emails));
?>