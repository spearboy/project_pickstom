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
    <title>Pickstom : 이메일 찾기</title>
</head>

<body>
    <? include "./common_include/header.php" ?>
    <main id="main" role="main">
        <div class="container">
            <div class="intro__text">
                <p>이메일 찾기</p>
            </div>
            <div class="intro__text2">
                <p>가입하실때 입력하신 정보를 정확히 입력해주세요.</p>
            </div>
            <div class="member__insert">
                <form id="idRecovery" name="siginSave" method="post">
                        <div class="input_wrapper">
                        <label for="userName">이름</label>
                        <input type="text" name="userName" id="userName" class="nameInput input_style onlyTextInput" autocomplete="off" class="input_style"
                            required>
                        <span class="error_text"></span>
                    </div>
                        <div class="input_wrapper">
                        <label for="userPhone">전화번호</label>
                        <input type="text" name="userPhone" id="userPhone" class="phoneNumberInput input_style onlyNumberInput" autocomplete="off" class="input_style"
                            required>
                        <span class="error_text"></span>
                    </div>
                    <div class="button__group">
                        <button type="submit" id="submitIdrecovery" class="blueBtn">이메일 찾기</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <? include "./common_include/footer.php" ?>
    <script src="./assets/js/id_recovery.js"></script>
</body>

</html>