<?php
    include "./util/connect.php";
    include "./util/session.php";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/signup.css">
    <? include "./common_include/lib.php" ?>
    <title>Pickstom : 회원가입</title>
    <!-- jQuery 전체 버전 추가 -->
    <script src="./assets/js/signup.js" defer></script>
</head>
<body>
    <div id="wrap">
        <? include "./common_include/header.php" ?>
        <main id="main" role="main">
            <div class="container">
                <div class="intro__text">
                    <p>회원가입</p>
                </div>
                <div class="member__insert">
                    <form id="signup_work" name="signup_work" method="post">
                        <div class="input_wrapper">
                            <label for="youName">이름</label>
                            <input tabindex="1" type="text" id="youName" class="nameInput input_style onlyTextInput" maxlength="10" name="youName" placeholder="이름을 입력해주세요." autocomplete="off" required>
                            <span class="error_text" id="youNameComment"></span>
                        </div>
                        <div class="input_wrapper">
                            <label for="youEmail">이메일</label>
                            <input tabindex="2" type="email" id="youEmail" class="emailInput input_style" name="youEmail" placeholder="abc@abc.com" autocomplete="off" required>
                            <span class="error_text" id="youEmailComment"></span>
                        </div>
                        <div class="input_wrapper">
                            <label for="youPass">비밀번호</label>
                        <div class="input-container">
                            <input tabindex="3" type="password" id="youPass" class="passwordInput input_style" name="youPass" placeholder="6자 이상 입력해주세요." autocomplete="off" required>
                            <span class="error_text" id="youPassComment"></span>
                            <i class="fas fa-eye-slash toggle-icon"></i>
                        </div>
                        </div>
                        <div class="input_wrapper">
                            <label for="youPass2">비밀번호 확인</label>
                        <div class="input-container">
                            <input tabindex="4" type="password" id="youPass2" class="passwordConfirmInput input_style" name="youPass2" placeholder="다시 한번 비밀번호를 입력해주세요." autocomplete="off" required>
                            <span class="error_text" id="youPass2Comment"></span>
                            <i class="fas fa-eye-slash toggle-icon"></i>
                        </div>
                        </div>
                        <div class="input_wrapper">
                            <label for="youPhone">전화번호</label>
                            <input tabindex="5" type="text" id="youPhone" name="youPhone" class="phoneNumberInput input_style onlyNumberInput" placeholder="전화번호를 입력해주세요." autocomplete="off" required>
                            <span class="error_text" id="youPhoneComment"></span>
                        </div>
                        <div class="df df1">
                            <input tabindex="6" type="checkbox" name="checkbox" id="checkbox1" onclick="toggleCheckboxes(this)">
                            <p>전체동의</p>
                        </div>
                        <div class="df">
                            <input tabindex="7" type="checkbox" name="checkbox" id="checkbox2" onclick="updateMainCheckbox()">
                            <p><em>[필수]</em>이용약관과 개인정보 수집 및 이용에 동의합니다.</p>
                        </div>
                        <div class="df">
                            <input tabindex="8" type="checkbox" name="checkbox" id="checkbox3" onclick="updateMainCheckbox()">
                            <p><em>[필수]</em>만 14세 이상입니다.</p>
                            <h4>만 19세 미만의 미성년자가 결제 시 법정대리인이 거래를 취소할 수 있습니다.</h4>
                        </div>
                        <div class="df">
                            <input tabindex="9" type="checkbox" name="checkbox" id="checkbox4" onclick="updateMainCheckbox()">
                            <p>[선택]이메일 및 SMS 마케팅 정보 수신에 동의합니다.</p>
                            <h4>회원은 언제든지 회원 정보에서 수신 거부로 변경할 수 있습니다.</h4>
                        </div>
                        <div class="center">
                            <button tabindex="10" id="submitSignup" type="submit" class="btn-style">가입하기</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <!-- //main -->
        <? include "./common_include/footer.php" ?>
    </div>
</body>
</html>