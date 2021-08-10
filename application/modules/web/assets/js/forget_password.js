"use strict";
var csrf_test_name=  $("#CSRF_TOKEN").val();

// ===========prevent page reload and click to the submit in forget password section==============
$('#loader').hide();
$("#forget_email").keypress('keyup', function (event) {
    if (event.keyCode == 13) {
        event.preventDefault();
        document.getElementById("forget_password_btn").click();
        $("#recover_message").html('');
        $('#loader').show();
    }
});
//========================for recover email =======================
$(document).ready(function () {
    $('#forget_password_btn').on('click', function (e) {
        e.preventDefault();
        var forget_email = $("input[name=forget_email]").val();
        $("#recover_message").html('');
        $('#loader').show();
        $.ajax({
            type: "post",
            async: true,
            dataType: "json",
            url: base_url+'forget_password',
            data: {csrf_test_name:csrf_test_name, email: forget_email},
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
    });
});
$('.page-wrapper').css({'background':'#fff'});
