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
    <title>Pickstom : 로그인</title>
</head>

<body>
    <? include "./common_include/header.php" ?>
    <main id="main" role="main">
        <div class="container">
            <div class="intro__text">
                <p>로그인</p>
            </div>
            <div class="member__insert">
                <form action="./util/siginSave.php" name="siginSave" method="post">
                    <div>
                        <label for="userEmail">이메일</label>
                        <input type="text" name="userEmail" id="userEmail" autocomplete="off" class="input_style"
                            required>
                    </div>
                    <div>
                        <label for="userPass">비밀번호</label>
                        <input type="password" name="userPass" id="userPass" autocomplete="off" class="input_style"
                            required>
                    </div>
                    <div id="search">
                        <div class="id-recovery">
                            <a href="id_recovery.php">이메일 찾기</a>
                        </div>
                        <div class="password-recovery">
                            <a href="password_recovery.php">비밀번호 찾기</a>
                        </div>
                    </div>
                    <div class="button__group">
                        <button type="submit" class="blueBtn">로그인</button>
                        <a href="/signup.php"><button type="button" class="whiteBtn">회원가입</button></a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <? include "./common_include/footer.php" ?>
</body>

</html>