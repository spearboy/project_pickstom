<?php
include "./util/connect.php";
include "./util/session.php";

// 로그인 여부 확인
if (!isset($_SESSION['userNum'])) {
    header("Location: signin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pickstaID = $_POST['pickstaID'];

    $sql = "UPDATE picksta SET pickstaDelete = 0 WHERE pickstaID = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("i", $pickstaID);
    $stmt->execute();

    header("Location: pickstaRead.php");
    exit();
} else {
    // GET 요청으로 접근한 경우, 삭제 요청을 POST로 보냅니다.
    $pickstaID = $_GET['pickstaID'];
    echo "<form id='deleteForm' action='pickstaDelete.php' method='post'>";
    echo "<input type='hidden' name='pickstaID' value='$pickstaID'>";
    echo "</form>";
    echo "<script>document.getElementById('deleteForm').submit();</script>";
}
?>
