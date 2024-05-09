/*global $, document, window, setTimeout, navigator, console, location*/
$(document).ready(function () {

    'use strict';

    var usernameError = true,
        emailError = true,
        passwordError = true,
        passConfirm = true;

    // Detect browser for css purpose
    if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
        $('.form form label').addClass('fontSwitch');
    }

    // Label effect
    $('input').focus(function () {

        $(this).siblings('label').addClass('active');
    });

    // Form validation
    $('input').blur(function () {

        // User Name
        if ($(this).hasClass('name')) {
            if ($(this).val().length === 0) {
                $(this).siblings('span.error').text('이름을 입력해 주세요!').fadeIn().parent('.form-group').addClass('hasError');
                usernameError = true;
            } else if ($(this).val().length > 0 && $(this).val().length < 2) {
                $(this).siblings('span.error').text('두글자 이상 입력해주세요!').fadeIn().parent('.form-group').addClass('hasError');
                usernameError = true;
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                usernameError = false;
            }
        }
        // Email
        if ($(this).hasClass('email')) {
            if ($(this).val().length == '') {
                $(this).siblings('span.error').text('이메일을 입력해 주세요!').fadeIn().parent('.form-group').addClass('hasError');
                emailError = true;
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                emailError = false;
            }
        }

        // PassWord
        if ($(this).hasClass('pass')) {
            if ($(this).val().length < 8) {
                $(this).siblings('span.error').text('8글자 이상 입력해주세요!').fadeIn().parent('.form-group').addClass('hasError');
                passwordError = true;
            } else {
                $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                passwordError = false;
            }
        }

        // PassWord confirmation
        if ($('.pass').val() !== $('.passConfirm').val()) {
            $('.passConfirm').siblings('.error').text('비밀번호가 / 일치하지 않습니다.').fadeIn().parent('.form-group').addClass('hasError');
            passConfirm = true;
        } else {
            $('.passConfirm').siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
            passConfirm = false;
        }

        // label effect
        if ($(this).val().length > 0) {
            $(this).siblings('label').addClass('active');
        } else {
            $(this).siblings('label').removeClass('active');
        }
    });


    // form switch
    $('a.switch').click(function (e) {
        e.preventDefault();
        var formPiece = $(this).parents('.form-peice');

        // Reset error messages
        formPiece.find('.error').text('').fadeOut();
        formPiece.find('.form-group').removeClass('hasError');

        // Switch forms
        if (!$(this).hasClass('active')) {
            $('a.switch').removeClass('active');
            $(this).addClass('active');
            formPiece.siblings('.form-peice').removeClass('switched');
            formPiece.addClass('switched');
        }
    });



    // Form submit
    $('form.login-form').submit(function(event) {
        event.preventDefault();
    
        if ($('#loginemail').val() != "" || $('#loginPassword').val() != "") {

            // Form data
            var formData = $(this).serialize(); // Serialize form data

            $.ajax({
                type: 'POST',
                url: '../../util/signin_work.php', // PHP 파일 경로
                data: formData,
                dataType: "json",
                success: function(data){
                    console.log(data.result)
                    if(data.result == "good") {
                        window.location.href="../../index.php";
                    } else {
                        alert('이메일 혹은 비밀번호를 확인해주세요.');
                    }
                }
            });
        }
    });
    // Form submit
    $('form.signup-form').submit(function(event) {
        event.preventDefault();
    
        if (usernameError == true || emailError == true || passwordError == true || passConfirm == true) {
            $('.name, .email, .pass, .passConfirm').blur();
        } else {
            // Form data
            var formData = $(this).serialize(); // Serialize form data
    
            // Send form data to server

            let email = $("#email").val();
            $.ajax({
                type: 'POST',
                url: '../../util/signup_work.php', // PHP 파일 경로
                data: formData,
                dataType: "json",
                success: function(data){
                    if(data.result == "good") {
                        $('.signup, .login').addClass('switched');
                        setTimeout(function() {
                            $('.signup, .login').hide();
                        }, 700);
                        setTimeout(function() {
                            $('.brand').addClass('active');
                        }, 300);
                        setTimeout(function() {
                            $('.heading').addClass('active');
                        }, 600);
                        setTimeout(function() {
                            $('.success-msg p').addClass('active');
                        }, 900);
                        setTimeout(function() {
                            $('.success-msg a').addClass('active');
                        }, 1050);
                        setTimeout(function() {
                            $('.form').hide();
                        }, 700);
                    } else {
                        alert('이');
                    }
                }
            });
        }
    });
    

    // Reload page
    $('a.profile').on('click', function () {
        location.reload(true);
    });


});
