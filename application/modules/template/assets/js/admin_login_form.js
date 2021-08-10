"use strict";
var csrf_test_name=  $("#CSRF_TOKEN").val();

// Demo access
$(document).ready(function() {
    var info = $('table tbody tr');
    info.click(function() {
        var email    = $(this).children().first().text(); 
        var password = $(this).children().first().next().text();
        $("input[name=email]").val(email);
        $("input[name=password]").val(password);
    });
});


$('#password').keypress(function (e) {
    if (e.which == 13) {
        $('form#validate').submit();
        return false;    
    }
});

$('#loader').hide();
$('#forget_password_form').hide();
$('#login_button').hide();
$('#forget_password_button').on('click', function () {
    $('#login_form').remove();
    $('#login_button').remove();
    $('#forget_password_form').show();
    $('#submit_button').show();
});

$('#submit_button').on('click',function (e) {
    e.preventDefault();
    var admin_email = $("input[name=admin_email]").val();
    $("#recover_message").html('');
    $('#loader').show();
    $.ajax({
        type: "post",
        async: true,
        dataType: "json",
        url: base_url+'forget_admin_password',
        data: {csrf_test_name:csrf_test_name,admin_email: admin_email},
        success: function (data) {
            $('#loader').hide();
            if (3 == data) {
                $("#recover_message").html(display('this_email_not_exits'));
                $("input[name=forget_email]").css({"border-color": "red"});
                return false;
            }
            if (1 == data) {
                $("#recover_message").html(display('you_have_receive_a_email_please_check_your_email')).css({"color": "green"});
                $("input[name=forget_email]").css({"border-color": "#dedede"});
            }
            if (2 == data) {
                $("#recover_message").html(display('email_not_send'));
            }
            if (4 == data) {
                $("#recover_message").html(display('please_try_again'));
            }
        }
    });
})
