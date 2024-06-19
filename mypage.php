<?php
    include "./util/connect.php";
    include "./util/session.php";
    include "./util/sessionCheck.php";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/mypage.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <? include "./common_include/lib.php" ?>
    <title>PICKSTOM</title>
    <script src="./assets/js/mypage.js"></script>
</head>
<body>
    <div id="wrap">
        <? include "./common_include/header.php" ?>
        <div class="container">
            <div class="mypage__wrap">
                <div class="side__menu">
                    <ul>
                        <li class="active">내 정보</li>
                        <li>나의 커스텀</li>
                    </ul>
                </div>
                <div class="mypage_contents_wrap">
                    <div class="mypage_profile">
                        <form action="./util/siginSave.php" name="siginSave" method="post">
                            <h2>내 정보</h2>
                            <div>
                                <p>이름</p>
                                <p><?=$_SESSION['userName']?></p>
                            </div>
                            <div>
                                <p>이메일</p>
                                <p><?=$_SESSION['userEmail']?></p>
                            </div>
                            <div>
                                <label for="phoneNum">전화번호</label>
                                <input type="text" name="phoneNum" id="phoneNum" autocomplete="off" class="input_style" value="<?=$_SESSION['userPhone']?>" required>
                            </div>
                            <div class="slide_pass">
                                <label for="correctPassword">현재 비밀번호</label>
                                <div class="input-container">
                                    <input type="password" name="correctPassword" id="correctPassword" autocomplete="off" class="input_style">
                                    <i class="fas fa-eye-slash toggle-icon"></i>
                                </div>
                            </div>
                            <div class="slide_pass">
                                <label for="newPassword">신규 비밀번호</label>
                                <div class="input-container">
                                    <input type="password" name="newPassword" id="newPassword" autocomplete="off" class="input_style">
                                    <i class="fas fa-eye-slash toggle-icon"></i>
                                </div>
                            </div>
                            <div class="slide_pass">
                                <label for="newPasswordCheck">신규 비밀번호 확인</label>
                                <div class="input-container">
                                    <input type="password" name="newPasswordCheck" id="newPasswordCheck" autocomplete="off" class="input_style">
                                    <i class="fas fa-eye-slash toggle-icon"></i>
                                </div>
                            </div>
                            <div class="btn">
                                <button type="submit">변경하기</button>
                            </div>
                        </form>
                    </div>
                    <div class="mypage_custom">
                        <h2>나의 커스텀</h2>
                        <div class="box_wrapper">
                        <?php
                                $userNum = $_SESSION['userNum'];

                                // 사용자의 이미지 가져오기
                                $sql = "SELECT imagePath,regtime,userFileName FROM userImages WHERE userNum = $userNum";
                                $result = $connect->query($sql);

                                // 이미지 출력
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        $dateTime = new DateTime($row['regtime']);
                                        $formattedDate = $dateTime->format('Y-m-d H:i'); // 초를 제외한 형식
                                
                                        echo '<div class="box" data-image-path="' . $row['imagePath'] . '" >';
                                            echo '<div class="image_box" style="background-image: url(' . $row['imagePath'] . ');"></div>';
                                            echo '<p>'.$row['userFileName'].'</p>';
                                            echo '<p>'.$formattedDate.'</p>';
                                        echo '</div>';
                                    }
                                } else {
                                    echo "해당 사용자의 이미지가 없습니다.";
                                }
                                

                                // 연결 종료
                                $connect->close();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include "./common_include/footer.php" ?>
    </div>
    <div class="view_mycustom_layer_bg">
        <div class="view_mycustom_layer">
            <div class="close_mycustom_layer"></div>
            <a class="view" href="" download></a>
        </div>
    </div>
</body>
</html>