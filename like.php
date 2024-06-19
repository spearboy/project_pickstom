<?php
include "./util/connect.php";
include "./util/session.php";

$response = array('status' => 'error');

if (isset($_SESSION['userNum']) && isset($_POST['pickstaID'])) {
    $userNum = $_SESSION['userNum'];
    $pickstaID = $_POST['pickstaID'];

    // 이미 좋아요 했는지 확인
    $sql = "SELECT * FROM likes WHERE userNum = ? AND pickstaID = ?";
    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ii", $userNum, $pickstaID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // 이미 좋아요 한 경우, 좋아요 취소
        $sql = "DELETE FROM likes WHERE userNum = ? AND pickstaID = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ii", $userNum, $pickstaID);
        $stmt->execute();
        $response['status'] = 'unliked';
    } else {
        // 좋아요 추가
        $sql = "INSERT INTO likes (userNum, pickstaID) VALUES (?, ?)";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("ii", $userNum, $pickstaID);
        $stmt->execute();
        $response['status'] = 'liked';
    }

    // 좋아요 수 업데이트
    $sqlLikeCount = "SELECT COUNT(*) as likeCount FROM likes WHERE pickstaID = ?";
    $stmtLikeCount = $connect->prepare($sqlLikeCount);
    $stmtLikeCount->bind_param("i", $pickstaID);
    $stmtLikeCount->execute();
    $resultLikeCount = $stmtLikeCount->get_result();
    $likeCount = $resultLikeCount->fetch_assoc()['likeCount'];

    $response['likeCount'] = $likeCount;
}

echo json_encode($response);
?>
