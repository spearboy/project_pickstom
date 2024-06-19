function togglePasswordFields() {
    var checkBox = document.getElementById("toggle-switch");
    var currentPassword = document.getElementById("correctPassword");
    var newPassword = document.getElementById("newPassword");
    var newPasswordCheck = document.getElementById("newPasswordCheck");
    if (checkBox.checked) {
        currentPassword.disabled = false;
        newPassword.disabled = false;
        newPasswordCheck.disabled = false;
        currentPassword.required = true;
        newPassword.required = true;
        newPasswordCheck.required = true;
    } else {
        currentPassword.disabled = true;
        newPassword.disabled = true;
        newPasswordCheck.disabled = true;
        currentPassword.required = false;
        newPassword.required = false;
        newPasswordCheck.required = false;
    }
}
function togglePasswordVisibility() {
    var currentPassword = document.getElementById("correctPassword");
    var newPassword = document.getElementById("newPassword");
    var newPasswordCheck = document.getElementById("newPasswordCheck");
    var passwordFields = [currentPassword, newPassword, newPasswordCheck];
    passwordFields.forEach(function (field) {
        if (field.type === "password") {
            field.type = "text";
        } else {
            field.type = "password";
        }
    });
}
document.addEventListener("DOMContentLoaded", function () {
    const toggleIcons = document.querySelectorAll('.toggle-icon');
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    // 비밀번호 입력 필드를 처음에 가려진 상태로 시작
    passwordInputs.forEach(input => {
        input.setAttribute('type', 'password');
    });
    toggleIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            const type = passwordInputs[0].getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInputs.forEach(input => {
                input.setAttribute('type', type);
            });
            // 아이콘 모양 변경
            toggleIcons.forEach(icon => {
                if (type === 'password') {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    });
});
//탭메뉴
$(document).ready(function () {
    const tabBtn = $(".side__menu > ul > li");
    const tabCont = $(".mypage_contents_wrap > div");
    tabBtn.click(function () {
        const index = $(this).index();
        // 현재 스크롤 위치 저장
        const scrollPos = $(window).scrollTop();
        $(this).addClass("active").siblings().removeClass("active");
        if (index === 0) {
            $(".mypage_profile").css("display", "block");
            $(".mypage_custom").css("display", "none");
        } else if (index === 1) {
            $(".mypage_profile").css("display", "none");
            $(".mypage_custom").css("display", "block");
        }
        // 저장한 스크롤 위치로 이동
        // $(window).scrollTop(scrollPos);
    });

    $(document).on('click','.box', function() {
        var imagePath = $(this).data('image-path');
        $('.view_mycustom_layer').find('.view').css('background-image', 'url(' + imagePath + ')');
        $('.view_mycustom_layer').find('.view').attr('href', imagePath);
        $('.view_mycustom_layer_bg').fadeIn(200,function(){
            $('.view_mycustom_layer').css('transform','translate(-50%,-50%) scale(1)');
        });
    });
    $(document).on('click','.close_mycustom_layer', function() {
            $('.view_mycustom_layer').css('transform','translate(-50%,-50%) scale(0)');
            setTimeout(() => {
                $('.view_mycustom_layer_bg').fadeOut(200);
            }, 300);
    });
});