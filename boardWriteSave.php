<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 작성</title>
</head>
<body>
<?php
    // 에러 리포팅 활성화
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // 절대 경로로 파일 포함
    include "./util/connect.php";
    include "./util/session.php";
    include "./util/sessionCheck.php";

    if (isset($_POST['boardTitle']) && isset($_POST['boardContents'])) {
        // 데이터베이스 연결 확인
        if ($connect) {
            $userNum = mysqli_real_escape_string($connect, $_SESSION['userNum']);
            $userAuthority = mysqli_real_escape_string($connect, $_SESSION['userAuthority']);
            $boardTitle = mysqli_real_escape_string($connect, $_POST['boardTitle']);
            $boardContents = mysqli_real_escape_string($connect, $_POST['boardContents']);
            $regTime = time();

            // // 파일 업로드 처리
            // $upload_dir = "./upload/";
            // $allowed_types = array('jpg', 'gif', 'png', 'webp');
            // $file_name = $_FILES['blogFile']['name'];
            // $file_tmp = $_FILES['blogFile']['tmp_name'];
            // $file_type = pathinfo($file_name, PATHINFO_EXTENSION);
            // $file_path = $upload_dir . basename($file_name);

            // $boardImage = ''; // 파일 경로 기본값 설정

            // if (!empty($file_name)) {
            //     if (!in_array($file_type, $allowed_types)) {
            //         echo "<script>alert('허용되지 않는 파일 형식입니다.');</script>";
            //         echo "<script>window.history.back();</script>";
            //         exit();
            //     }

            //     if ($_FILES['blogFile']['size'] > 1048576) {
            //         echo "<script>alert('파일 크기가 1MB를 초과할 수 없습니다.');</script>";
            //         echo "<script>window.history.back();</script>";
            //         exit();
            //     }

            //     if (!is_dir($upload_dir)) {
            //         mkdir($upload_dir, 0777, true);
            //     }

            //     if (move_uploaded_file($file_tmp, $file_path)) {
            //         $boardImage = $file_path;
                } else {
                    $error = $_FILES['blogFile']['error'];
                    echo "<script>alert('파일 업로드에 실패했습니다. 오류 코드: $error');</script>";
                    echo "<script>window.history.back();</script>";
                    exit();
                }
            }

            if (empty($boardTitle) || empty($boardContents)) {
                echo "<script>alert('제목 또는 내용을 작성해주세요.');</script>";
                echo "<script>window.history.back();</script>";
            } else {
                $sql = "INSERT INTO board (userNum, boardTitle, boardContents, regTime, ) VALUES ('$userNum', '$boardTitle', '$boardContents', '$regTime')";
                if($userAuthority === 'user'){
                    $sql = "INSERT INTO board (userNum, boardTitle, boardContents, regTime, boardType) VALUES ('$userNum', '$boardTitle', '$boardContents', '$regTime', '0')";
                } else {
                    $sql = "INSERT INTO board (userNum, boardTitle, boardContents, regTime, boardType) VALUES ('$userNum', '$boardTitle', '$boardContents', '$regTime', '1')";
                }
                if ($connect->query($sql) === TRUE) {
                    echo "<script>alert('게시글이 성공적으로 작성되었습니다.'); window.location.href = 'board.php';</script>";
                } else {
                    $error = $connect->error; // SQL 에러 메시지
                    echo "<script>alert('게시글 작성에 오류가 있습니다. 오류: " . addslashes($error) . "');</script>";
                }
            }
    //     } else {
    //         echo "<script>alert('데이터베이스에 연결할 수 없습니다.');</script>";
    //     }
    // } else {
    //     echo "<script>alert('POST 데이터가 전달되지 않았습니다.');</script>";
    // }
?>
</body>
</html>