<?php
    include "./util/connect.php";
    include "./util/session.php";

?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <? include "./common_include/lib.php" ?>
    <link rel="stylesheet" href="assets/css/about.scss">
    <title>Pickstom : 소개</title>
</head>

<body>
<div id="wrap">
<? include "./common_include/header.php" ?>
        <main id="main">
            <div class="container">
                <div class="imgbox">
                    <img src="../assets/images/about_img1.svg" alt="">
                </div>
                <div class="nav">
                    <ul>
                        <li>
                            <span class="highlight">Pickstom</span>은 반려견을 위한 맞춤형 의류 디자인 서비스를 제공하여,
                                <p>소중한 반려견에게 개성을 더할 수 있는 기회를 선사합니다.</p> 
                                <p>독특한 패턴을 선택하고 원하는 원단을 골라 나만의 스타일을 반영한 옷을 디자인할 수 있습니다.</p> 
                                <p>몇 가지 간단한 단계만 거치면, 창의력을 발휘해 세상에 하나뿐인 반려견 옷을 완성할 수 있습니다.</p> 
                            <span class="highlight">Pickstom</span>은 반려견과의 특별한 추억을 만들고 싶은 모든 반려인들에게 최적의 선택입니다.
                            <p>쉽게 접근할 수 있는 사용자 친화적인 인터페이스와 다양한 커스터마이징 옵션을 통해,</p>
                            <p>반려견에게 어울리는 완벽한 옷을 디자인해보세요.</p>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
        <? include "./common_include/footer.php" ?>
    </div>
    
</body>

</html>