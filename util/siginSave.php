<?php
include "./connect.php";
include "./session.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['userEmail']) && isset($_POST['userPass'])) {
        $userEmail = $connect->real_escape_string(trim($_POST['userEmail']));
        $userPass = $connect->real_escape_string(trim($_POST['userPass']));

        // 유효성 검사
        if (empty($userEmail) || empty($userPass)) {
            echo "<script>alert('아이디와 비밀번호를 입력해주세요.'); history.back();</script>";
            exit;
        }

        // 쿼리 작성 및 실행
        $stmt = $connect->prepare("SELECT userNum, userName, userEmail, userPass, userPhone, userAuthority FROM pickstomuser WHERE userEmail = ?");
        if ($stmt === false) {
            echo "<script>alert('쿼리 준비에 실패했습니다.'); history.back();</script>";
            exit;
        }
        $stmt->bind_param("s", $userEmail);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $info = $result->fetch_assoc();

            // 비밀번호 확인
            if (password_verify($userPass, $info['userPass'])) {
                // 세션 설정
                $_SESSION['userNum'] = $info['userNum'];
                $_SESSION['userName'] = $info['userName'];
                $_SESSION['userEmail'] = $info['userEmail'];
                $_SESSION['userPhone'] = $info['userPhone'];
                $_SESSION['userAuthority'] = $info['userAuthority'];

                echo "<script>alert('🐾 환영합니다! 🐾'); location.href='/';</script>";
            } else {
                echo "<script>alert('비밀번호가 틀렸습니다.'); history.back();</script>";
            }
        } else {
            echo "<script>alert('존재하지 않는 아이디입니다.'); history.back();</script>";
        }

        $stmt->close();
        $connect->close();
    } else if (isset($_POST['phoneNum']) || isset($_POST['correctPassword']) || isset($_POST['newPassword']) || isset($_POST['newPasswordCheck'])) {
        $userNum = $_SESSION['userNum']; // 세션에서 사용자 번호를 가져옴

        // 전화번호 업데이트
        $phoneUpdated = false;
        if (isset($_POST['phoneNum']) && !empty($_POST['phoneNum'])) {
            $phoneNum = $connect->real_escape_string(trim($_POST['phoneNum']));
            $updateQuery = "UPDATE pickstomuser SET userPhone = ? WHERE userNum = ?";
            $stmt = $connect->prepare($updateQuery);
            $stmt->bind_param("si", $phoneNum, $userNum);
            $stmt->execute();
            $stmt->close();
            
            // 세션에 저장된 전화번호 갱신
            $_SESSION['userPhone'] = $phoneNum;
            $phoneUpdated = true;
        }

        // 비밀번호 변경
        if (!empty($_POST['correctPassword']) && !empty($_POST['newPassword']) && !empty($_POST['newPasswordCheck'])) {
            $correctPassword = $connect->real_escape_string(trim($_POST['correctPassword']));
            $newPassword = $connect->real_escape_string(trim($_POST['newPassword']));
            $newPasswordCheck = $connect->real_escape_string(trim($_POST['newPasswordCheck']));

            if ($newPassword !== $newPasswordCheck) {
                echo "<script>alert('새로운 비밀번호가 일치하지 않습니다.'); history.back();</script>";
                exit;
            }

            // 기존 비밀번호 확인
            $query = "SELECT userPass FROM pickstomuser WHERE userNum = ?";
            $stmt = $connect->prepare($query);
            $stmt->bind_param("i", $userNum);
            $stmt->execute();
            $stmt->bind_result($dbPassword);
            $stmt->fetch();
            $stmt->close();

            if (!password_verify($correctPassword, $dbPassword)) {
                echo "<script>alert('현재 비밀번호가 맞지 않습니다.'); history.back();</script>";
                exit;
            }

            // 비밀번호 업데이트
            $newPasswordHashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateQuery = "UPDATE pickstomuser SET userPass = ? WHERE userNum = ?";
            $stmt = $connect->prepare($updateQuery);
            $stmt->bind_param("si", $newPasswordHashed, $userNum);
            $stmt->execute();
            $stmt->close();

            echo "<script>alert('비밀번호가 성공적으로 업데이트되었습니다.'); location.href='/mypage.php';</script>";
            exit();
        }

        // 변경 사항이 있으면 페이지 새로고침
        if ($phoneUpdated || (!empty($_POST['correctPassword']) && !empty($_POST['newPassword']) && !empty($_POST['newPasswordCheck']))) {
            echo "<script>alert('정보가 성공적으로 업데이트되었습니다.'); window.location.href = '/mypage.php';</script>";
            exit();
        } else {
            echo "<script>alert('변경할 정보를 입력하세요.'); history.back();</script>";
        }
    } else {
        echo "<script>alert('잘못된 접근입니다. 관리자에게 문의하세요!'); history.back();</script>";
    }
}
?>
