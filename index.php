<?php
    include "./util/connect.php";
    include "./util/session.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/js/swiper.min.js"></script>

    <link rel="stylesheet" href="./assets/plugin/slider.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    <title>Pickstom</title>
</head>

<body>
    <?
        echo "<pre>";
        var_dump($_SESSION);
        echo "</pre>";
    ?>
    <div class="wrapper">
        <div class="header">
            <div class="menu">
                <span class="line"></span>
                <span class="line"></span>
                <span class="line"></span>
            </div>
        </div>
        <section class="section section-hero">
            <div class="design_element"></div>
            <p class="section-hero-title">For<br>dogs Create<br>special clothes!</p>
            <p class="section-hero-text">Do you have a design you want?<br>Do you want a special outfit for your beloved
                dog?<br>Use your ideas and creativity to design your own clothes You can customize it!</p>
            <div class="pickstom_btn">Curstom start</div>
        </section>
        <section class="section section-list">
            <div class="list_wrapper">
                <div class="list_box"><img src="./assets/images/section_img01.png" alt=""></div>
                <div class="list_box"><img src="./assets/images/section_img02.png" alt=""></div>
                <div class="list_box"><img src="./assets/images/section_img03.png" alt=""></div>
                <div class="list_box"><img src="./assets/images/section_img04.png" alt=""></div>
            </div>
        </section>
        <section class="section section-manual">
            <div class="manual-wrapper">
                <p>Manual</p>
                <div class="manual-content"></div>
            </div>
        </section>
        <section class="section section-gallery">
            <div class="gallery-wrapper">
                <p>Gallery</p>
                <!-- Swiper -->
                <div class="swiper-container two">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="https://theme-land.com/sapp/demo/assets/img/screenshots/3.jpg" alt="slide 1">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="https://theme-land.com/sapp/demo/assets/img/screenshots/1.jpg" alt="slide 2">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="https://theme-land.com/sapp/demo/assets/img/screenshots/5.jpg" alt="slide 3">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="https://theme-land.com/sapp/demo/assets/img/screenshots/4.jpg" alt="slide 4">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-image">
                                <img src="https://theme-land.com/sapp/demo/assets/img/screenshots/2.jpg" alt="slide 5">
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
        <footer class="footer">
            <p>Copyright 2021. hyunmin, seoyeon, byunghyun All rights reserved.</p>
        </footer>
    </div>
    <script src="./assets/plugin/slider.js"></script>
    <script src="./assets/js/main.js"></script>
</body>

</html>