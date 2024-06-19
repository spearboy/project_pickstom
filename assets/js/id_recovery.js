
$(document).on('click', '#submitIdrecovery', function (e) {
    e.preventDefault();
    var formData = $("#idRecovery").serialize();
    var layer = $("#idRecovery");
    if (commonCheckValue(layer)) {
        $.ajax({
            url: '../../util/find_Email.php',
            type: 'POST',
            dataType: 'json',
            data: formData,
            success: function (response) {
                console.log(response.emails);
                $('.loading_wrapper').fadeIn(300,function(){
                    if(response.result == 'not_found') {
                        setTimeout(function(){
                            show_common_layer('정보와 일치하는 계정이 존재하지 않습니다.')
                        }, 2000);
                    }else if(response.result == 'error'){
                        setTimeout(function(){
                            show_common_layer('에러가 발생했습니다 관리자에게 문의해주세요.')
                        }, 2000);
                    }else if(response.result == 'success'){
                        setTimeout(function(){
                            $('.email_count').text(response.emails.length);
                            for(var i = 0; i<response.emails.length; i++){
                                $('.email_list').append(`<p>`+response.emails[i]+`</p>`)
                            }
                            $('.email_result').css({'transform':'translate(-50%, -50%) scale(1)'}); 
                        }, 2000);
                    }
                })
            }
        });
    }
})