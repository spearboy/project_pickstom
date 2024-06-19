<?php
    include "./util/connect.php";
    include "./util/session.php";
?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/signin.css">
    <? include "./common_include/lib.php" ?>
    <title>Pickstom : 비밀번호 찾기</title>
</head>

<body>
    <? include "./common_include/header.php" ?>
    <main id="main" role="main">
        <div class="container">
            <div class="intro__text">
                <p>비밀번호 찾기</p>
            </div>
            <div class="intro__text2">
                <p>가입하실때 입력하신 정보를 정확히 입력해주세요.</p>
            </div>
            <div class="member__insert">
                <form id="passwordRecovery" name="siginSave" method="post">
                    <div class="input_wrapper">
                        <label for="userEmail">이메일</label>
                        <input type="text" name="userEmail" id="userEmail" class="emailInput input_style" autocomplete="off" required>
                        <span class="error_text"></span>
                    </div>
                    <div class="input_wrapper">
                        <label for="userName">이름</label>
                        <input type="text" name="userName" id="userName" class="nameInput input_style onlyTextInput" autocomplete="off" required>
                        <span class="error_text"></span>
                    </div>
                    <div class="input_wrapper">
                        <label for="userPhone">전화번호</label>
                        <input type="text" name="userPhone" id="userPhone" class="phoneNumberInput input_style onlyNumberInput" autocomplete="off" required>
                        <span class="error_text"></span>
                    </div>
                    <div class="button__group">
                        <button type="submit" id="submitCodePasswordRecovery" class="blueBtn">인증메일 발송</button>
                    </div>
                </form>
            </div>
            <div class="member__insert2" style="display:none;">
                <form id="passwordRecovery_code" name="siginSave" method="post">
                    <div class="input_wrapper">
                        <label for="code">보안코드</label>
                        <input type="text" name="code" id="code" class="input_style" autocomplete="off" required>
                        <span class="error_text"></span>
                    </div>
                    <div class="button__group">
                        <button type="submit" id="submitRecovery_code" class="blueBtn">인증하기</button>
                    </div>
                </form>
            </div>
            <div class="member__insert3" style="display:none;">
                <form id="recoveryChangePass" name="siginSave" method="post">
                    <input type="text" id="save_Email" name="save_Email" style="position: absolute; top: 0px; left: 0px; overflow: hidden; width: 0px; height: 0px;">
                    <div class="input_wrapper">
                        <label for="newPass">신규 비밀번호</label>
                        <input type="password" name="newPass" id="newPass" class="newPasswordInput input_style" autocomplete="off" required>
                        <span class="error_text"></span>
                    </div>
                    <div class="input_wrapper">
                        <label for="newPassC">신규 비밀번호 확인</label>
                        <input type="password" name="newPassC" id="newPassC" class="confirmNewPasswordInput input_style" autocomplete="off" required>
                        <span class="error_text"></span>
                    </div>
                    <div class="button__group">
                        <button type="submit" id="submitChangePass" class="blueBtn">변경하기</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <? include "./common_include/footer.php" ?>
    <script src="./assets/js/password_recovery.js"></script>
</body>

</html>