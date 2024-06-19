<?php
// 에러 출력 설정
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$userNum = $_SESSION['userNum'];

$log_file = __DIR__ . "/request_log.txt";

// 데이터베이스 연결 파일 포함
include "./util/connect.php";

// 요청을 기록하는 함수
function log_request($message) {
    global $log_file;
    file_put_contents($log_file, $message . "\n", FILE_APPEND);
}

log_request("Script started: " . date("Y-m-d H:i:s"));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    log_request("POST request received");

    if (isset($_FILES['file'])) {
        log_request("File data received");

        $file = $_FILES['file'];
        $userFileName = pathinfo($file['name'], PATHINFO_FILENAME);
        $fileExt = pathinfo($file['name'], PATHINFO_EXTENSION);
        $currentDate = date('Y_m_d');
        $currentDateTime = date('Y-m-d H:i:s');

        // 파일명에서 공백을 밑줄로 대체
        $sanitizedFileName = str_replace(' ', '_', $userFileName);

        // 상대 경로로 업로드 디렉토리 설정
        $upload_dir_relative = "uploads/$userNum/";
        $upload_dir_absolute = __DIR__ . "/$upload_dir_relative";

        // 디렉토리가 존재하지 않으면 생성
        if (!file_exists($upload_dir_absolute)) {
            if (!mkdir($upload_dir_absolute, 0777, true)) {
                log_request("Failed to create upload directory");
                echo "ERROR: Failed to create upload directory";
                exit();
            }
            log_request("Upload directory created");
        }

        // 최종 파일명 생성
        $finalFileName = "${userNum}_${sanitizedFileName}_${currentDate}.${fileExt}";
        $file_path_relative = $upload_dir_relative . $finalFileName;
        $file_path_absolute = $upload_dir_absolute . $finalFileName;

        // 파일명 중복 확인
        if (file_exists($file_path_absolute)) {
            log_request("File already exists: " . $file_path_absolute);
            echo "ERROR: File already exists";
            exit();
        }

        if (move_uploaded_file($file['tmp_name'], $file_path_absolute)) {
            log_request("File saved successfully: " . $file_path_absolute);

            // 데이터베이스에 상대 경로로 경로 저장
            $stmt = $connect->prepare("INSERT INTO userImages (userNum, imagePath, regtime, userFileName) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isss", $userNum, $file_path_relative, $currentDateTime, $userFileName);

            if ($stmt->execute()) {
                log_request("Database entry created: userNum = $userNum, imagePath = $file_path_relative, regtime = $currentDateTime, userFileName = $userFileName");
                echo "SUCCESS";
            } else {
                log_request("Database entry failed: " . $stmt->error);
                echo "ERROR: Failed to save file information to database";
            }

            $stmt->close();
        } else {
            log_request("Failed to save file");
            echo "ERROR: Failed to save file";
        }
    } else {
        log_request("No file data received");
        echo "ERROR: No file data received";
    }
} else {
    log_request("Invalid request method: " . $_SERVER['REQUEST_METHOD']);
    echo "ERROR: Invalid request method: " . $_SERVER['REQUEST_METHOD'];
}
?>
