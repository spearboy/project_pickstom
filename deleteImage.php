<?php
include "./connect.php";
include "./session.php";

// POST 데이터 가져오기
$data = json_decode(file_get_contents("php://input"), true);
$imagePath = $data['imagePath'];

// 이미지 삭제 쿼리 실행
$sql = "DELETE FROM userImages WHERE imagePath = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("s", $imagePath);

$response = array();

if ($stmt->execute()) {
    $response['success'] = true;
    // 파일 시스템에서 이미지 삭제
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
} else {
    $response['success'] = false;
}

$stmt->close();
$connect->close();

echo json_encode($response);
?>
