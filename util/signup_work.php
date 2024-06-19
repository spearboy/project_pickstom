<?php
    header('Content-Type: application/json'); // JSON 형식으로 응답
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include "./connect.php";
    include "./session.php";

    $name = mysqli_real_escape_string($connect, $_POST['youName']);
    $email = mysqli_real_escape_string($connect, $_POST['youEmail']);
    $phone = mysqli_real_escape_string($connect, $_POST['youPhone']);
    $password = mysqli_real_escape_string($connect, $_POST['youPass']);
    $password2 = mysqli_real_escape_string($connect, $_POST['youPass2']);

    // echo $name, $email, $phone, $password, $password2;

    $response = array();
    // $response["result"] = $name, $email, $phone, $password, $password2;
    // echo json_encode($response);

    // // 비밀번호 일치 여부 확인
    if ($password != $password2) {
        $response["result"] = "password_mismatch";
        echo json_encode($response);
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // // 이메일 중복 확인
    $check_email_query = "SELECT * FROM pickstomuser WHERE userEmail='$email'";
    $check_email_result = $connect->query($check_email_query);

    if ($check_email_result) {
        if ($check_email_result->num_rows > 0) {
            // 이미 이메일이 존재하는 경우
            $response["result"] = "email_exists";
        } else {
            // // 새로운 사용자 추가
            $sql = "INSERT INTO pickstomuser(userEmail, userPass, userName, userPhone) VALUES('$email', '$hashed_password', '$name', '$phone')";
            $connect->query($sql);
            $response["result"] = "success";
        }
    } else {
        $response["result"] = "query_failed";
        $response["error"] = $connect->error;
    }

    echo json_encode($response);
?>
