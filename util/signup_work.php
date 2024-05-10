
<?php
    include "./connect.php";
    include "./session.php";

    $name = mysqli_real_escape_string($connect, $_POST['username']);
    $email = mysqli_real_escape_string($connect, $_POST['emailAdress']);
    $phone = mysqli_real_escape_string($connect, $_POST['phone']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $check_email_query = "SELECT * FROM pickstomuser WHERE userEmail='$email'";
    $check_email_result = $connect->query($check_email_query);


    if ($check_email_result->num_rows > 0) {
        // 이미 이메일이 존재하는 경우
        $jsonResult = "bad";
    } else {
        $sql = "INSERT INTO pickstomuser(userEmail,userPass,userName,userPhone) VALUES('$email','$hashed_password','$name','$phone')";
        $connect -> query($sql);

        $sql = "SELECT userEmail, userPass, userName FROM pickstomuser WHERE userEmail = '$email'";
        $result = $connect -> query($sql);
        if($result) {
            $userInfo = $result -> fetch_array(MYSQLI_ASSOC);

            $_SESSION['userEmail'] = $userInfo['userEmail'];
            $_SESSION['userName'] = $userInfo['userName'];

            $jsonResult = "good";
        }else {

            $jsonResult = "bad";
        }
    }

    echo json_encode(array("result" => $jsonResult));
?>