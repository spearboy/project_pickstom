let password_incrrect = 0;
function toggleCheckboxes(mainCheckbox) {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = mainCheckbox.checked;
    });
}
function updateMainCheckbox() {
    const mainCheckbox = document.getElementById('checkbox1');
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="checkbox"]:not(#checkbox1)');
    mainCheckbox.checked = Array.from(checkboxes).every(checkbox => checkbox.checked);
}
$('#youPass').on('input', function () {
    let getYouPass = $("#youPass").val();
    let getYouPassNum = getYouPass.search(/[0-9]/g);
    let getYouPassEng = getYouPass.search(/[a-z]/ig);
    let getYouPassSpe = getYouPass.search(/[`~!@@#$%^&*|₩₩₩'₩";:₩/?]/gi);
    if (getYouPass.length < 8 || getYouPass.length > 20) {
        $('#youPass').addClass('error_alert_border');
        $('#youPass').parent().find('.error_text').text('8자리 ~ 20자리 이내로 입력해주세요.');
        password_incrrect = 1;
    } else if (getYouPass.search(/\s/) != -1) {
        $('#youPass').addClass('error_alert_border');
        $('#youPass').parent().find('.error_text').text('비밀번호는 공백없이 입력해주세요.');
        password_incrrect = 1;
    } else if (getYouPassNum < 0 || getYouPassEng < 0 || getYouPassSpe < 0) {
        $('#youPass').addClass('error_alert_border');
        $('#youPass').parent().find('.error_text').text('영문, 숫자, 특수문자를 혼합하여 입력해주세요.');
        password_incrrect = 1;
    } else {
        $('#youPass').removeClass('error_alert_border');
        $('#youPass').parent().find('.error_text').text('');
        password_incrrect = 0;
    }
})
$('#youPass2').on('input', function () {
    if ($(this).val() == $('#youPass').val()) {
        $('#youPass2').removeClass('error_alert_border');
        $('#youPass2').parent().find('.error_text').text('');
    } else {
        $('#youPass2').addClass('error_alert_border');
        $('#youPass2').parent().find('.error_text').text('비밀번호가 일치하지 않습니다.');
    }
})
// function emailChecking() {
//     let youEmail = $("#youEmail").val();
//     let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;
//     if (youEmail === '') {
//         $("#youEmailComment").text("➟ 이메일을 입력해주세요.");
//         $("#youEmail").focus();
//         return false;
//     } else if (!emailPattern.test(youEmail)) {
//         $("#youEmailComment").text("➟ 유효한 이메일 주소를 입력해주세요.");
//         $("#youEmail").focus();
//         return false;
//     }
// }
$(document).on('click', '#submitSignup', function (e) {
    e.preventDefault();
    var formData = $("#signup_work").serialize();
    var layer = $("#signup_work");
    if (password_incrrect > 0) {
        return false;
    }
    if (commonCheckValue(layer)) {
        // console.log(true)
        let check2 = $("#checkbox2");
        let check3 = $("#checkbox3");
        if (check2.is(":checked") && check3.is(":checked")) {
            $.ajax({
                url: '../../util/signup_work.php',
                type: 'POST',
                dataType: 'json',
                data: formData,
                success: function (response) {
                    $('.loading_wrapper').fadeIn(300, function () {
                        if (response.result == 'email_exists') {
                            setTimeout(() => {
                                $('.loading_wrapper').fadeOut(100);
                                $('#youEmail').addClass('error_alert_border');
                                $('#youEmail').parent().find('.error_text').text('중복된 이메일 입니다.');
                            }, 2000);
                        } else if (response.result == 'success') {
                            setTimeout(() => {
                                $('.signup_result').css({ 'transform': 'translate(-50%, -50%) scale(1)' });
                            }, 2000);
                        }
                    })
                    if (response.status === 'error') {
                        $("#youEmailComment").text(response.message);
                        isEmailCheck = false;
                    } else {
                        $("#youEmailComment").text(response.message);
                        isEmailCheck = true;
                    }
                }
            });
        } else {
            alert("'필수'약관에 동의해야 회원가입이 가능합니다.")
        }
    }
})
document.addEventListener("DOMContentLoaded", function () {
    const toggleIcons = document.querySelectorAll('.toggle-icon');
    const passwordInputs = document.querySelectorAll('input[type="password"]');
    toggleIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            const type = passwordInputs[0].getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInputs.forEach(input => {
                input.setAttribute('type', type);
            });
            if (type === 'password') {
                toggleIcons.forEach(icon => {
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                });
            } else {
                toggleIcons.forEach(icon => {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                });
            }
        });
    });
});