let anmation = bodymovin.loadAnimation({
    container: document.getElementById('lottie'),
    renderer: 'svg',
    loop: true, //반복재생
    autoplay: true, //자동재생
    path: '/assets/lottie/loading.json', // 파일 경로 넣거나
});

function commonCheckValue(btn) {
    var check = 0;
    btn.find('input').each(function (index, item) {
        if ($(this).hasClass('skip_check')) {
            return
        } else {
            var test = 0;
            if ($(item).val() == '') {
                if ($(item).hasClass('emailInput')) {
                    $(item).parent().find('.error_text').text('이메일을 입력해주세요.');
                    $(item).focus();
                    test++;
                } else if ($(item).hasClass('passwordInput')) {
                    $(item).parent().find('.error_text').text('비밀번호를 입력해주세요.');
                    $(item).focus();
                    test++;
                } else if ($(item).hasClass('passwordConfirmInput')) {
                    $(item).parent().find('.error_text').text('비밀번호를 다시한번 입력해주세요.');
                    $(item).focus();
                    test++;
                } else if ($(item).hasClass('phoneNumberInput')) {
                    $(item).parent().find('.error_text').text('전화번호를 입력해주세요.');
                    $(item).focus();
                    test++;
                } else if ($(item).hasClass('currentPasswordInput')) {
                    $(item).parent().find('.error_text').text('비밀번호를 입력해주세요.');
                    $(item).focus();
                    test++;
                } else if ($(item).hasClass('newPasswordInput')) {
                    $(item).parent().find('.error_text').text('새로운 비밀번호를 입력해주세요.');
                    $(item).focus();
                    test++;
                } else if ($(item).hasClass('confirmNewPasswordInput')) {
                    $(item).parent().find('.error_text').text('새로운 비밀번호를 다시한번 입력해주세요.');
                    $(item).focus();
                    test++;
                } else if ($(item).hasClass('contentInput')) {
                    $(item).parent().find('.error_text').text('내용을 입력해주세요.');
                    $(item).focus();
                    test++;
                } else if ($(item).hasClass('nameInput')) {
                    $(item).parent().find('.error_text').text('이름을 입력해주세요.');
                    $(item).focus();
                    test++;
                }
            } else if ($(item).hasClass('emailInput')) {
                var regExp = /^[0-9a-zA-Z.;\-!#]+@[A-Za-z0-9\-]+\.[A-Za-z]+/;
                if (!regExp.test($(item).val())) {
                    $(item).parent().find('.error_text').text('이메일이 형식이 일치하지 않습니다.');
                    $(item).focus();
                    test++;
                }
            } else if ($(item).hasClass('phoneNumberInput')) {
                var regExpPhoneCode = /^[0-9]{6,14}$/;
                if (!regExpPhoneCode.test($(item).val())) {
                    $(item).parent().find('.error_text').text('전화번호 형식이 일치하지 않습니다.');
                    $(item).focus();
                    test++;
                }
            }
            if (test == 0) {
                $(item).removeClass('error_alert_border')
                $(item).parent().find('.error_text').text('')
            } else {
                if ($(this).attr('type') != 'hidden') {
                    $(item).addClass('error_alert_border');
                    check++;
                }
            }
        }
    })
    if (check > 0) {
        return false;
    } else {
        return true;
    }
}
$('.onlyNumberInput').on('input', function () {
    $(this).val($(this).val().replace(/[ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/g, ''));
    $(this).val($(this).val().replace(/[^0-9]/g, ""));
})
$('.onlyTextInput').on('input', function () {
    $(this).val($(this).val().replace(/[^A-z|ㄱ-ㅎ|ㅏ-ㅣ|가-힣]/g, ""));
})

const profileToggle = document.querySelector(".member .on");
const profileBox = document.querySelector(".profile");

if (profileToggle) {
    profileToggle.addEventListener("click", function (event) {
        event.preventDefault();
        profileBox.classList.toggle("show");
    });
}
function show_common_layer(text) {
    $('.loading_wrapper').fadeIn(300,function(){
        $('.common_layer').find('p').text(text)
        setTimeout(function(){
            $('.common_layer').css({'transform':'translate(-50%, -50%) scale(1)'});
        }, 2000);
    })
}
$(document).on('click','.close_common_layer',function(){
    $('.common_layer').css({'transform':'translate(-50%, -50%) scale(0)'});
    setTimeout(function(){
        $('.common_layer').find('p').text('')
        $('.loading_wrapper').fadeOut(); 
    }, 300);
})
