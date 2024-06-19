<?php
    include "./connect.php";
    include "./session.php";

    $userEmail = mysqli_real_escape_string($connect, $_POST['save_Email']);
    $newPass = mysqli_real_escape_string($connect, $_POST['newPass']);

    $sql = "SELECT userEmail, userName, userPhone FROM pickstomuser WHERE userEmail = '$userEmail'";
    $result = $connect->query($sql);

    $jsonResult = "";
    $emails = array();

    if($result){
        $count = $result->num_rows;
        if($count == 0) {
            $jsonResult = "not_found";
        } else {
            $hashed_password = password_hash($newPass, PASSWORD_DEFAULT);
            // Update userPass with new password
            $updateSql = "UPDATE pickstomuser SET userPass = '$hashed_password' WHERE userEmail = '$userEmail'";
            $updateResult = $connect->query($updateSql);
            
            if($updateResult) {
                $jsonResult = "success";
            } else {
                $jsonResult = "update_error";
            }
        }
    } else {
        $jsonResult = "error";
    }

    echo json_encode(array("result" => $jsonResult, ));
?>