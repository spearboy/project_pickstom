<?php
include "./util/connect.php";
include "./util/session.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commentID = $_POST['commentID'];

    // 로그인 여부 확인 및 작성자 확인
    if (isset($_SESSION['userNum'])) {
        $userNum = $_SESSION['userNum'];
        $sql = "DELETE FROM comments WHERE commentID = ? AND userNum = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ii", $commentID, $userNum);
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false]);
    }
}
?>
