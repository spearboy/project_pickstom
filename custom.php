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
    <?php include "./common_include/lib.php"; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="assets/css/custom.css">
    <title>Pickstom : 커스텀</title>
    <script src="assets/js/fabric.js"></script>
    <script src="assets/js/html2canvas.js"></script>
    <script src="assets/js/custom.js"></script>
</head>

<body>
    <div id="wrap">
        <?php include "./common_include/header.php"; ?>
        <div class="container custom_container">
            <div class="custom__wrap">
                <div class="cont" style="background-image: url('./assets/images/black.png');">
                    <canvas id="pickstom_canvas"></canvas>
                </div>
                <div class="aside">
                    <input type="file" id="addedFile" style="display: none;">
                    <div class="controls">
                        <div class="base_color_picker">
                            <p>옷 색상 선택</p>
                            <div class="color_box" data-type="color_1"><span style="background-color: #252526"></span></div>
                            <div class="color_box" data-type="color_2"><span style="background-color: #E7D49A"></span></div>
                            <div class="color_box" data-type="color_3"><span style="background-color: #E9E8E3"></span></div>
                            <div class="color_box" data-type="color_4"><span style="background-color: #89888C"></span></div>
                            <div class="color_box" data-type="color_5"><span style="background-color: #A8CFC6"></span></div>
                        </div>
                        <div class="control_btns">
                            <!-- <p>커스텀 버튼</p> -->
                            <input type="file" id="addedFileJ" style="display: none;">
                            <p>글꼴 사이즈 및 색상 선택하기</p>
                            <div class="font_check">
                                <input type="text" class="onlyNumberInput" id="fontSize" value="20" min="8" max="30" maxlength="2" style=" width:30px;" >
                                <input type="color" id="textColorPicker" value="#000000" title="글자색 선택">
                            </div>
                            <div class="controls_btn add_text"><i class="fa-solid fa-font"></i>글자 추가하기</div>
                            <select id="fontFamily" style="visibility: hidden;">
                                <option value="Arial">Arial</option>
                                <option value="Times New Roman">Times New Roman</option>
                                <option value="Courier New">Courier New</option>
                            </select>
                            <div class="inner_costom_box">
                                <!-- <p>무료이미지 추가하기</p> --> 
                                <div class="free_img_wrapper"></div>
                                <div class="controls_btn add_img" title="이미지 삽입" ><i class="fa-sharp fa-solid fa-icons"></i>  무료 이미지 추가하기</div>
                                <div class="controls_btn add_own_img" title="내 이미지 삽입"><i class="fa-solid fa-image"></i> 내 이미지 추가하기</div>
                            </div>
                        </div>
                        <div class="control_btns">
                            <!-- <p>액션 버튼</p> -->
                            <div class="controls_btn undo_canvas"><i class="fa-solid fa-rotate-left"></i></div>
                            <div class="controls_btn redo_canvas"><i class="fa-solid fa-rotate-right"></i></div>
                            <div class="controls_btn clear_canvas"><i class="fa-solid fa-trash-can"></i></div>
                        </div>
                        <div class="controls_btn save_canvas"><i class="fa-solid fa-floppy-disk"></i> 저장하기</div>
                    </div>
                    <div class="popup" id="imagePopup">
                        <span class="close-btn" id="closePopup">닫기</span>
                        <div class="tab">
                            <button class="tablinks" onclick="openTab(event, 'Images')" id="defaultOpen">이미지</button>
                            <button class="tablinks" onclick="openTab(event, 'Embroidery')">자수</button>
                        </div>
                        <div id="Images" class="tabcontent">
                            <div class="image-selection" id="imageSelection">
                                <!-- 이미지가 동적으로 추가될 곳 -->
                            </div>
                        </div>
                        <div id="Embroidery" class="tabcontent">
                            <div class="image-selection" id="embroiderySelection">
                                <!-- 자수 이미지가 동적으로 추가될 곳 -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="save_custom_confirm_layer">
            <div class="save_image_layer">
                <button id="closeBtn" class="close-btn">&times;</button>
                <form id="save_image_layer">
                    <p>저장할 커스텀 이름</p>
                    <input type="text" id="saveImg" name="saveImg" class="input_style" maxlength="20" placeholder="최대 20글자까지 가능합니다.">
                    <button type="submit" class="blueBtn">저장하기</button>
                </form>
            </div>
        </div>
        <?php include "./common_include/footer.php"; ?>
    </div>
</body>

</html>
