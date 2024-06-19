let email_code;
let user_email;
let password_incrrect = 0;

$(document).on('click', '#submitCodePasswordRecovery', function (e) {
    e.preventDefault();
    var formData = $("#passwordRecovery").serialize();
    var layer = $("#passwordRecovery");
    if (commonCheckValue(layer)) {
        $.ajax({
            url: '../../util/check_user.php',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function (response) {
                console.log(response);  // 서버로부터의 응답을 확인
                $('.loading_wrapper').fadeIn(300, function() {
                    if(response.result === 'not_found') {
                        setTimeout(function() {
                            show_common_layer('정보와 일치하는 계정이 존재하지 않습니다.')
                        }, 2000);
                    } else if(response.result === 'success') {
                        setTimeout(function() {
                            email_code = response.code;
                            user_email = $('#userEmail').val();
                            $('.loading_wrapper').fadeOut(100);
                            $('.member__insert').css('display','none');
                            $('.member__insert2').css('display','flex');
                            $('.intro__text2').text('보안코드가 '+user_email+'으로 발송되었습니다.');
                        }, 2000);
                    } else {
                        setTimeout(function() {
                            show_common_layer('에러가 발생했습니다 관리자에게 문의해주세요.')
                        }, 2000);
                    }
                });
            },
            error: function(response) {
                console.log(response);
                alert('서버와의 통신 중 오류가 발생했습니다.');
            }
        });
    }
});
$(document).on('click', '#submitRecovery_code', function (e) {
    e.preventDefault();
    $('.loading_wrapper').fadeIn(300, function() {
        setTimeout(function() {
            if($('#code').val() == email_code){
                $('.loading_wrapper').fadeOut(100);
                $('.member__insert2').css('display','none');
                $('.member__insert3').css('display','flex');
                $('#save_Email').val(user_email)
                $('.intro__text2').text('신규 비밀번호를 설정해주세요.');
            }else {
                $('.loading_wrapper').fadeOut(100);
                $('#code').addClass('error_alert_border');
                $('#code').parent().find('.error_text').text('코드가 일치하지 않습니다.');
            }
        }, 2000);
    });
});

$('#newPass').on('input',function(){
    let getYouPass = $("#newPass").val();
    let getYouPassNum = getYouPass.search(/[0-9]/g);
    let getYouPassEng = getYouPass.search(/[a-z]/ig);
    let getYouPassSpe = getYouPass.search(/[`~!@@#$%^&*|₩₩₩'₩";:₩/?]/gi);

    if(getYouPass.length < 8 || getYouPass.length > 20){
        $('#newPass').addClass('error_alert_border');
        $('#newPass').parent().find('.error_text').text('8자리 ~ 20자리 이내로 입력해주세요.');
        password_incrrect = 1;
    } else if (getYouPass.search(/\s/) != -1){
        $('#newPass').addClass('error_alert_border');
        $('#newPass').parent().find('.error_text').text('비밀번호는 공백없이 입력해주세요.');
        password_incrrect = 1;
    } else if (getYouPassNum < 0 || getYouPassEng < 0 || getYouPassSpe < 0 ){
        $('#newPass').addClass('error_alert_border');
        $('#newPass').parent().find('.error_text').text('영문, 숫자, 특수문자를 혼합하여 입력해주세요.');
        password_incrrect = 1;
    }else {
        $('#newPass').removeClass('error_alert_border');
        $('#newPass').parent().find('.error_text').text('');
        password_incrrect = 0;
    }
})
$('#newPassC').on('input',function(){
    if($(this).val() == $('#newPass').val()){
        $('#newPassC').removeClass('error_alert_border');
        $('#newPassC').parent().find('.error_text').text('');
    }else {
        $('#newPassC').addClass('error_alert_border');
        $('#newPassC').parent().find('.error_text').text('비밀번호가 일치하지 않습니다.');
    }
})

$(document).on('click', '#submitChangePass', function (e) {
    e.preventDefault();
    var formData = $("#recoveryChangePass").serialize();
    var layer = $("#recoveryChangePass");
    if(password_incrrect > 0) {
        return false;
    }
    if (commonCheckValue(layer)) {
        $.ajax({
            url: '../../util/find_Pass.php',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function (response) {
                console.log(response);  // 서버로부터의 응답을 확인
                $('.loading_wrapper').fadeIn(300, function() {
                    if(response.result === 'success') {
                        setTimeout(function() {
                            $('.password_result').css({'transform':'translate(-50%, -50%) scale(1)'}); 
                        }, 2000);
                    }
                });
            }
        });
    }
});