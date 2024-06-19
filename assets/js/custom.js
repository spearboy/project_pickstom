document.addEventListener("DOMContentLoaded", function () {
    var canvas = new fabric.Canvas('pickstom_canvas');

    // 캔버스의 너비와 높이 설정
    var canvasWidth = 300; // 너비
    var canvasHeight = 400; // 높이
    canvas.setDimensions({ width: canvasWidth, height: canvasHeight });

    var undoStack = [];
    var redoStack = [];
    var lastSelectedText = null; // 마지막으로 클릭한 텍스트 요소 저장

    // 이미지 이름 배열 생성
    var imageNames = [];
    for (var i = 1; i <= 169; i++) {
        var num = i.toString().padStart(3, '0');
        imageNames.push('patch/patch_img' + num + '.png');
    }
    var embroideryNames = []; // 자수 이미지 이름 추가

    // 팝업 열기 및 닫기 함수
    function openPopup() {
        document.getElementById('imagePopup').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('imagePopup').style.display = 'none';
    }

    // 탭 전환 함수
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    // 이미지 선택 섹션에 이미지 추가
    function populateImages() {
        var freeImgWrapper = document.querySelector('.free_img_wrapper');
        imageNames.forEach(function (imageName) {
            var img = document.createElement('img');
            img.src = './assets/images/' + imageName;
            img.alt = imageName;
            img.className = 'selectable-img';
            freeImgWrapper.appendChild(img);
        });

        var embroiderySelectionDiv = document.getElementById('embroiderySelection');
        embroideryNames.forEach(function (imageName) {
            var img = document.createElement('img');
            img.src = './assets/images/' + imageName;
            img.alt = imageName;
            img.className = 'selectable-img';
            embroiderySelectionDiv.appendChild(img);
        });

        // 이미지 클릭 이벤트 리스너 추가
        document.querySelectorAll('.selectable-img').forEach(function (img) {
            img.addEventListener('click', function () {
                document.querySelectorAll('.selectable-img').forEach(function (img) {
                    img.classList.remove('active');
                });
                img.classList.add('active');
            });
        });
    }

    // 이미지 파일을 캔버스에 추가하는 함수 (크기 조절 가능)
    function addOwnImage(event) {
        var input = event.target;
        var file = input.files[0];
        if (!file) return;

        var validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validImageTypes.includes(file.type)) {
            alert('형식이 올바르지 않습니다.');
            return;
        }

        var reader = new FileReader();
        reader.onload = function () {
            var dataURL = reader.result;
            fabric.Image.fromURL(dataURL, function (img) {
                var scaleFactor = 100 / Math.max(img.width, img.height);
                img.set({
                    left: 10,
                    top: 10,
                    scaleX: scaleFactor,
                    scaleY: scaleFactor,
                    selectable: true // 이미지를 선택할 수 있도록 설정
                });
                canvas.add(img);
                saveState();
            });
        };
        reader.readAsDataURL(file);
    }

    // 파일 입력 요소에 change 이벤트 리스너 추가
    var addedFileJ = document.getElementById('addedFileJ');
    if (addedFileJ) {
        addedFileJ.addEventListener('change', addOwnImage);
    }

    // 이미지 파일을 캔버스에 추가하는 함수 (크기 조절 불가능)
    function addImage(event) {
        var input = event.target;
        var file = input.files[0];
        if (!file) return;

        var validImageTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!validImageTypes.includes(file.type)) {
            alert('형식이 올바르지 않습니다.');
            return;
        }

        var reader = new FileReader();
        reader.onload = function () {
            var dataURL = reader.result;
            fabric.Image.fromURL(dataURL, function (img) {
                var scaleFactor = 100 / Math.max(img.width, img.height);
                img.set({
                    left: 10,
                    top: 10,
                    scaleX: scaleFactor,
                    scaleY: scaleFactor,
                    hasControls: false, // 크기 조절 불가능하게 설정
                    lockScalingX: true,
                    lockScalingY: true,
                    lockRotation: true,
                    selectable: true // 이미지가 드래그 가능하도록 설정
                });
                canvas.add(img);
                saveState();
            });
        };

        reader.readAsDataURL(file);
    }

    // 선택된 객체를 삭제하는 함수
    function deleteSelectedObject() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            canvas.remove(activeObject);
            saveState();
        }
    }

    // 마지막으로 클릭한 객체를 가장 위로 올리는 함수
    function bringToFront() {
        var activeObject = canvas.getActiveObject();
        if (activeObject) {
            canvas.bringToFront(activeObject);
        }
    }

    // 텍스트 객체 추가 함수
    function addText() {
        var fontFamily = document.getElementById('fontFamily').value;
        var fontSize = parseInt(document.getElementById('fontSize').value, 10);
        var textColor = document.getElementById('textColorPicker').value;
        var text = new fabric.Textbox('Enter text here', {
            left: Math.random() * (canvas.width - 100),
            top: Math.random() * (canvas.height - 50),
            width: 150,
            fontSize: fontSize,
            fontFamily: fontFamily,
            fill: textColor,
            selectable: true // 텍스트가 드래그 가능하도록 설정
        });

        // 마지막으로 클릭한 텍스트 요소 업데이트
        text.on('selected', function() {
            lastSelectedText = text;
        });

        // 캔버스에 텍스트 추가
        canvas.add(text);
        saveState();
    }

    // 글자색 변경 함수
    function changeTextColor(event) {
        var color = event.target.value;
        if (lastSelectedText) {
            lastSelectedText.set('fill', color);
            canvas.renderAll();
            saveState();
        }
    }

    // 글자 크기 변경 함수
    function changeFontSize(event) {
        var fontSize = parseInt(event.target.value, 10);
        if (lastSelectedText) {
            lastSelectedText.set('fontSize', fontSize);
            canvas.renderAll();
            saveState();
        }
    }

    // 글꼴 변경 함수
    function changeFontFamily(event) {
        var fontFamily = event.target.value;
        if (lastSelectedText) {
            lastSelectedText.set('fontFamily', fontFamily);
            canvas.renderAll();
            saveState();
        }
    }

    // 캔버스를 초기화하는 함수
    function clearCanvas() {
        canvas.clear();
        saveState();
    }

    // 상태 저장 함수 (undo/redo 기능을 위한)
    function saveState() {
        undoStack.push(JSON.stringify(canvas));
        redoStack = []; // redo 스택 초기화
    }

    // 뒤로가기 기능
    function undo() {
        if (undoStack.length > 0) {
            redoStack.push(undoStack.pop());
            var state = undoStack[undoStack.length - 1];
            if (state) {
                canvas.loadFromJSON(state, canvas.renderAll.bind(canvas));
            } else {
                canvas.clear();
            }
        }
    }

    // 앞으로가기 기능
    function redo() {
        if (redoStack.length > 0) {
            var state = redoStack.pop();
            if (state) {
                undoStack.push(state);
                canvas.loadFromJSON(state, canvas.renderAll.bind(canvas));
            }
        }
    }

    // 이벤트 리스너를 추가하기 전에 요소들이 존재하는지 확인합니다.
    var addRectButton = document.querySelector('.add_rect');
    if (addRectButton) {
        addRectButton.addEventListener('click', addRectangle);
    }

    var addImgButton = document.querySelector('.add_img');
    if (addImgButton) {
        addImgButton.addEventListener('click', function () {
            var activeImage = document.querySelector('.free_img_wrapper .selectable-img.active');
            if (activeImage) {
                fabric.Image.fromURL(activeImage.src, function (img) {
                    var scaleFactor = 100 / Math.max(img.width, img.height);
                    img.set({
                        left: 10,
                        top: 10,
                        scaleX: scaleFactor,
                        scaleY: scaleFactor,
                        hasControls: false, // 크기 조절 불가능하게 설정
                        lockScalingX: true,
                        lockScalingY: true,
                        lockRotation: true,
                        selectable: true // 이미지가 드래그 가능하도록 설정
                    });
                    canvas.add(img);
                    saveState();
                });
            }
        });
    }

    var addOwnImgButton = document.querySelector('.add_own_img');
    if (addOwnImgButton) {
        addOwnImgButton.addEventListener('click', function () {
            document.getElementById('addedFileJ').click();
        });
    }

    var addTextButton = document.querySelector('.add_text');
    if (addTextButton) {
        addTextButton.addEventListener('click', addText);
    }

    var textColorPicker = document.getElementById('textColorPicker');
    if (textColorPicker) {
        textColorPicker.addEventListener('change', changeTextColor);
    }

    var fontSizePicker = document.getElementById('fontSize');
    if (fontSizePicker) {
        fontSizePicker.addEventListener('change', changeFontSize);
    }

    var fontFamilyPicker = document.getElementById('fontFamily');
    if (fontFamilyPicker) {
        fontFamilyPicker.addEventListener('change', changeFontFamily);
    }

    var addedFile = document.getElementById('addedFile');
    if (addedFile) {
        addedFile.addEventListener('change', addImage);
    }

    var clearCanvasButton = document.querySelector('.clear_canvas');
    if (clearCanvasButton) {
        clearCanvasButton.addEventListener('click', clearCanvas);
    }

    var undoButton = document.querySelector('.undo_canvas');
    if (undoButton) {
        undoButton.addEventListener('click', undo);
    }

    var redoButton = document.querySelector('.redo_canvas');
    if (redoButton) {
        redoButton.addEventListener('click', redo);
    }

    $(document).on("click", '.save_canvas', function() {
        // 파일명을 입력받기 위해 저장 레이어를 보여줍니다.
        $('.save_custom_confirm_layer').show();
    });

    $(document).on("submit", '#save_image_layer', function(event) {
        event.preventDefault();

        var fileName = $('#saveImg').val().trim();
        if (!fileName) {
            alert('파일명을 입력해주세요.');
            return;
        }
        $('.custom__wrap .cont canvas').css('border','0px');
        setTimeout(() => {
            $('.custom__wrap .cont canvas').css('border','2px dashed rgb(116, 155, 255)');
        }, 1000);
        html2canvas(document.querySelector('.cont')).then(function(canvas) {
            canvas.toBlob(function(blob) {
                var formData = new FormData();
                formData.append('file', blob, fileName + '.png'); // 기본 파일명으로 전송

                $.ajax({
                    type: "POST",
                    url: "/save_image.php",
                    data: formData,
                    processData: false, // FormData를 문자열로 변환하지 않음
                    contentType: false, // jQuery가 Content-Type을 설정하지 않도록 함
                    success: function(data) {
                        console.log("Response from server: " + data);
                        alert("성공적으로 저장되었습니다. 마이페이지에서 확인가능합니다.");
                        $('.save_custom_confirm_layer').hide();
                        $('.save_custom_confirm_layer').find('input').val('');
                    },
                    error: function(xhr, status, error) {
                        alert("error");
                        console.error("Error details:", xhr, status, error);
                    }
                });
            }, 'image/png');
        });
    });

    var closePopupButton = document.getElementById('closePopup');
    if (closePopupButton) {
        closePopupButton.addEventListener('click', closePopup);
    }

    // 백스페이스 키를 눌렀을 때 선택된 객체를 삭제하는 이벤트 리스너 추가
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Backspace' || event.key === 'Delete') {
            var activeObject = canvas.getActiveObject();
            if (activeObject && !(document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA')) {
                deleteSelectedObject();
            }
        }
    });

    // 마우스 클릭 이벤트 리스너 추가
    canvas.on('mouse:down', function (event) {
        if (event.target) {
            bringToFront();
            if (event.target.type === 'textbox') {
                lastSelectedText = event.target; // 마지막으로 클릭한 텍스트 요소 업데이트
            }
        }
    });

    document.addEventListener('mousedown', function (event) {
        if (event.target.tagName !== 'CANVAS' && event.target.className.indexOf('selectable-img') === -1) {
            canvas.discardActiveObject().renderAll();
        }
    });

    // 캔버스 밖으로 나가지 않게 설정
    canvas.on('object:moving', function (e) {
        var obj = e.target;
        if (obj.left < 0) {
            obj.left = 0;
        }
        if (obj.top < 0) {
            obj.top = 0;
        }
        if (obj.left + obj.width * obj.scaleX > canvas.width) {
            obj.left = canvas.width - obj.width * obj.scaleX;
        }
        if (obj.top + obj.height * obj.scaleY > canvas.height) {
            obj.top = canvas.height - obj.height * obj.scaleY;
        }
    });

    // 크기 조정 제한 설정
    canvas.on('object:scaling', function(e) {
        var obj = e.target;
        if (obj.width * obj.scaleX > canvas.width) {
            obj.scaleX = canvas.width / obj.width;
        }
        if (obj.height * obj.scaleY > canvas.height) {
            obj.scaleY = canvas.height / obj.height;
        }
        if (obj.width * obj.scaleX < 10) { // 최소 크기 제한
            obj.scaleX = 10 / obj.width;
        }
        if (obj.height * obj.scaleY < 10) { // 최소 크기 제한
            obj.scaleY = 10 / obj.height;
        }
    });

    $(document).on('click', '.color_box', function() {
        var colorMap = {
            'color_1': 'black.png',
            'color_2': 'yellow.png',
            'color_3': 'white.png',
            'color_4': 'gray.png',
            'color_5': 'mint.png'
        };

        var color = $(this).data('type');
        var imageUrl = colorMap[color];

        if (imageUrl) {
            $('.cont').css({'background-image': 'url("./assets/images/'+imageUrl+'")'});
            $('.loading_wrapper').fadeIn(300,function(){
                setTimeout(function () {
                    $('.loading_wrapper').fadeOut(300)
                },2000)
            })
        }
    });

    // 페이지 로드 시 이미지 선택 섹션에 이미지 추가
    populateImages();
});

// 탭 클릭 이벤트 리스너 추가
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('defaultOpen').click();
});

function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName('tabcontent');
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = 'none';
    }
    tablinks = document.getElementsByClassName('tablinks');
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(' active', '');
    }
    document.getElementById(tabName).style.display = 'block';
    evt.currentTarget.className += ' active';
}

document.addEventListener("DOMContentLoaded", function() {
    const images = document.querySelectorAll('.free_img_wrapper img');

    images.forEach(img => {
        img.addEventListener('click', function() {
            // Remove 'clicked' class from all images
            images.forEach(i => i.classList.remove('clicked'));
            // Add 'clicked' class to the clicked image
            this.classList.add('clicked');
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const closeBtn = document.getElementById("closeBtn");
    const customConfirmLayer = document.querySelector(".save_custom_confirm_layer");

    closeBtn.addEventListener("click", function() {
        customConfirmLayer.style.display = "none";
    });
});
