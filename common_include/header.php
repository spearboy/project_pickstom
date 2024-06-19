<div class="loading_wrapper">
    <div class="lottie-container loading_content" id="lottie"></div>
    <div class="signup_result">
        <p>가입이 완료되었습니다!</p>
        <a href="../signin.php" class="blueBtn">로그인</a>
    </div>
    <div class="email_result">
        <p>총 <span class="email_count"></span>개의 이메일이 존재합니다.</p>
        <div class="email_list">
        </div>
        <a href="../signin.php" class="blueBtn">로그인</a>
    </div>
    <div class="password_result">
        <p>비밀번호 변경이 완료되었습니다.</p>
        <a href="../signin.php" class="blueBtn">로그인</a>
    </div>
    <div class="common_layer">
        <p></p>
        <div class="blueBtn close_common_layer">확인</div>
    </div>
</div>
<header id="header">
    <div class="container">
        <div class="logo">
            <a href="./">
                <img src="/assets/images/logo.svg" alt="">
            </a>
        </div>
        <div class="nav">
            <a href="./about.php">
                <p>소개</p>
            </a>
            <a href="./custom.php">
                <p>커스텀</p>
            </a>
            <a href="./board.php">
                <p>게시판</p>
            </a>
            <a href="./pickstaRead.php">
                <p>픽스타그램</p>
            </a>
            <div class="member">
                <ul>
                    <?php if (isset($_SESSION['userName'])) {?>
                        <li class="on"><a href="#"><img src="/assets/images/imgg.svg" alt=""></a></li>
                    <?php } else { ?>
                        <li class="off"><a href="../signin.php">로그인</a></li>
                    <?php } ?>
                </ul>
                <div class="profile">
                    <?php if (isset($_SESSION['userAuthority']) && $_SESSION['userAuthority'] == 'admin') { ?>
                        <span class="admin_mark"><?echo $_SESSION['userAuthority'];?></span>
                    <?php } ?>
                    <div class="prof"><?=$_SESSION['userName']?></div>
                    <div class="title">
                        <div class="user"><?=$_SESSION['userName']?></div>
                        <div class="user"><?=$_SESSION['userEmail']?></div>
                        <!-- <a href="#" class="logout"><span class="blind">로그아웃</span></a> -->
                    </div>
                    <ul>
                        <li><a href="../../util/signout_work.php" class="logout">로그아웃</a></li>
                        <li><a href="../mypage.php">마이페이지</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>