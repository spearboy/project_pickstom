<?php
include "./util/connect.php";
include "./util/session.php";

$data = json_decode(file_get_contents('php://input'), true);
$imageID = $data['imageID'];

// 데이터베이스에서 이미지 경로 가져오기
$sql = "SELECT imagePath FROM userImages WHERE imageID = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param('i', $imageID);
$stmt->execute();
$stmt->bind_result($imagePath);
$stmt->fetch();
$stmt->close();

if ($imagePath) {
    // 서버에서 이미지 파일 삭제
    if (unlink($imagePath)) {
        // 데이터베이스에서 이미지 레코드 삭제
        $sql = "DELETE FROM userImages WHERE imageID = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param('i', $imageID);
        $stmt->execute();
        $stmt->close();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => '이미지 파일 삭제에 실패했습니다.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => '이미지를 찾을 수 없습니다.']);
}

// 데이터베이스 연결 종료
$connect->close();
?>
