<?php
include "./util/connect.php";
include "./util/session.php";
include "./util/sessionCheck.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 데이터 가져오기
    $pickstaTitle = $connect->real_escape_string($_POST['pickstaTitle']);
    $pickstaCont = $connect->real_escape_string($_POST['pickstaCont']);
    $userNum = $_SESSION['userNum'];
    $pickstaAuthor = $_SESSION['userName'];
    $pickstaImgFile = $connect->real_escape_string($_POST['selectedImage']);
    $pickstaCate = '0';  // 기본값 설정

    if (empty($pickstaImgFile)) {
        echo "<script>alert('이미지를 선택해주세요.'); history.back();</script>";
        exit();
    }

    $pickstaRegTime = time();

    // 데이터 입력
    $stmt = $connect->prepare("INSERT INTO picksta (userNum, pickstaTitle, pickstaCont, pickstaCate, pickstaAuthor, pickstaRegTime, pickstaView, pickstaLike, pickstaImgFile, pickstaImgSize) 
        VALUES (?, ?, ?, ?, ?, ?, 0, 0, ?, 0)");

    // prepare() 함수 오류 확인
    if ($stmt === false) {
        error_log("Prepare failed: " . $connect->error);
        echo "<script>alert('Prepare failed: " . addslashes($connect->error) . "');</script>";
        die("Prepare failed: " . $connect->error);
    }

    // 파라미터 바인딩
    if (!$stmt->bind_param("issssis", $userNum, $pickstaTitle, $pickstaCont, $pickstaCate, $pickstaAuthor, $pickstaRegTime, $pickstaImgFile)) {
        error_log("Bind param failed: " . $stmt->error);
        echo "<script>alert('Bind param failed: " . addslashes($stmt->error) . "');</script>";
        die("Bind param failed: " . $stmt->error);
    }

    // 디버그: 바인딩된 값 확인
    error_log("Bind param: $userNum, $pickstaTitle, $pickstaCont, $pickstaCate, $pickstaAuthor, $pickstaRegTime, $pickstaImgFile");

    // 실행
    if ($stmt->execute()) {
        echo "<script>alert('게시글이 성공적으로 작성되었습니다.'); location.href='pickstaRead.php';</script>";
    } else {
        error_log("Execute failed: " . $stmt->error);
        echo "<script>alert('Execute failed: " . addslashes($stmt->error) . "');</script>";
        echo "<script>alert('게시글 작성에 실패했습니다. 다시 시도해 주세요.');</script>";
    }

    // 완료 후 정리
    $stmt->close();
    $connect->close();

} else {
    // POST 방식이 아닌 경우
    echo "<script>alert('잘못된 접근방식입니다. 관리자에게 문의하세요');</script>";
}
?>
