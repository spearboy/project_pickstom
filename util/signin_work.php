<?php
    include "./connect.php";
    include "./session.php";

    $loginemail = mysqli_real_escape_string($connect, $_POST['loginemail']);
    $loginPassword = mysqli_real_escape_string($connect, $_POST['loginPassword']);

    $sql = "SELECT userEmail, userPass, userName FROM pickstomuser WHERE userEmail = '$loginemail'";
    $result = $connect -> query($sql);

    
    if($result){
        $count = $result -> num_rows;
        if($count == 0) {
            $jsonResult = "bad";
        }else {
            $userInfo = $result -> fetch_array(MYSQLI_ASSOC);

            if(password_verify($loginPassword, $userInfo['userPass'])){
                $_SESSION['userEmail'] = $userInfo['userEmail'];
                $_SESSION['userName'] = $userInfo['userName'];
                
                $jsonResult = "good";
            }else {
                $jsonResult = "bad";
            }
        }
    }
    echo json_encode(array("result" => $jsonResult));
?>