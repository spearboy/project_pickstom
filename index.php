<?php
include "./util/connect.php";
include "./util/session.php";
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/main.css">
    <?php include "./common_include/lib.php"; ?>
    <title>PICKSTOM</title>
</head>

<body>
    <div id="wrap">
        <?php include "./common_include/header.php"; ?>
        <section id="section">
            <div>
                <h1>반려견에게<br>
                    <span class="highlight">우리만의</span> 맞춤옷을<br>
                    선물해주세요
                </h1>
                <h2>
                    원하는 디자인이 있으신가요?
                </h2>
                <p>
                    본인만의 특별한 디자인을 만들고 싶으신가요?<br>
                    픽스텀에서 한번 시도해보세요!
                </p>
                <div class="btn">
                    <a href="./custom.php">
                        <button>
                            시작하기
                        </button>
                    </a>
                </div>
            </div>
        </section>
        <article id="slider">
            <div class="scroll_top">
                <img src="./assets/images/a1.svg" alt="">
                <img src="./assets/images/a1.svg" alt="">
                <img src="./assets/images/a1.svg" alt="">
                <img src="./assets/images/a1.svg" alt="">
            </div>
            <div class="scroll_middle">
                <img src="./assets/images/a2.svg" alt="">
                <img src="./assets/images/a2.svg" alt="">
                <img src="./assets/images/a2.svg" alt="">
                <img src="./assets/images/a2.svg" alt="">
            </div>
            <div class="scroll_bottom">
                <img src="./assets/images/a3.svg" alt="">
                <img src="./assets/images/a3.svg" alt="">
                <img src="./assets/images/a3.svg" alt="">
                <img src="./assets/images/a3.svg" alt="">
            </div>
        </article>
        <main id="main">
            <div>
                <h1>픽스텀이란?</h1>
                <h2>픽스텀은 고르다의 <span>Pick</span>과<br>
                    주문제작의 <span>Custom</span>을 합친 합성어로
                </h2>
                <h3>
                    반려견의 개성을 한껏 살린 <span class="highlight">나만의 디자인</span> 을 제작할 수 있는 서비스입니다.
                </h3>
            </div>
        </main>
        <div id="service">
            <div class="container">
                <div class="box1">
                    <img src="./assets/images/b1.svg" alt="">
                    <h1>디자인 스튜디오</h1>
                    <h2>자신만의 독특한 반려견 옷을 디자인해 보세요.
                        색상, 패턴, 재질을 선택하고, 원하는 스타
                        일을 자유롭게 조합해 볼 수 있습니다.<br>
                        창의력을 발휘하여 반려견의 개성을 표현하는
                        완벽한 의상을 만들어 보세요!</h2>
                </div>
                <div class="box2">
                    <img src="./assets/images/b2.svg" alt="">
                    <h1>이미지 업로드</h1>
                    <h2>가지고 있는 사진이나 그래픽을 직접 업로드하여 디자인에 포함시킬 수 있습니다.<br>
                        사랑스러운 반려견의 이미지로 옷을 꾸며 특별
                        한 의미를 더하거나, 특별한 기념일에 맞춰 개성 있는 옷을 제작해보세요.</h2>
                </div>
                <div class="box3">
                    <img src="./assets/images/b3.svg" alt="">
                    <h1>디자인 저장 및 회원 전용 갤러리</h1>
                    <h2>디자인한 강아지 옷을 간편하게 저장하고 언제든지 접근하세요.
                        사용자 전용 갤러리에서는 과거의 모든 작업을
                        보관하고, 새로운 옷을 만들 때 영감을 얻을 수
                        있습니다.</h2>
                </div>
                <div class="box4">
                    <img src="./assets/images/b4.svg" alt="">
                    <h1>커뮤니티 게시판</h1>
                    <h2>디자인 아이디어를 공유하고 다른 사용자들과 소통하세요.
                        게시판을 통해 팁과 조언을 주고받으며 더욱 창의적이고
                        재미있는 디자인을 만들어낼 수 있습니다.</h2>
                </div>
            </div>
        </div>
        <contents id="contents">
            <div class="container">
                <h1>픽스텀을 이용해보세요!</h1>
                <h2>픽스텀은 회원들의 니즈를 빠르게 캐치해 적용합니다.</h2>
            </div>
        </contents>
        <div id="review">
            <div class="container">
                <?php
                $sql = "SELECT * FROM picksta WHERE pickstaDelete = 1 ORDER BY pickstaLike DESC LIMIT 8";
                $stmt = $connect->prepare($sql);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='reviewbox'>";
                        echo "<div class='box_top'>";
                        echo "<img src='" . htmlspecialchars($row['pickstaImgFile']) . "' alt='" . htmlspecialchars($row['pickstaTitle']) . "'>";
                        echo "</div>";
                        echo "<div class='box_bottom'>";
                        echo "<h1>" . htmlspecialchars($row['pickstaAuthor']) . "</h1>";
                        echo "<p>" . htmlspecialchars($row['pickstaCont']) . "</p>";
                        echo "</div>";
                        echo "</div>";
                    }
                } else {
                    echo "<p class='empty'>게시글이 없습니다.</p>";
                }
                ?>
            </div>
        </div>
        <?php include "./common_include/footer.php"; ?>
    </div>
</body>

</html>
