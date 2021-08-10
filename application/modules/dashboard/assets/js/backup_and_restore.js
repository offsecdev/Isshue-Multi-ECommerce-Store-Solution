$(document).ready(function () {
    "use strict";
    var form = $("#brFrm");
    var message = $("#message");

    //upload process
    form.on('submit', function (e) {
        e.preventDefault();

        var x = confirm(display("are_you_sure"));
        if (!x) return false;

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            dataType: 'json',
            data: $(this).serialize(),
            beforeSend: function () {
                message.html('<i class="ti-settings fa fa-spin"></i> '+display("please_wait")).removeClass('hide').addClass('alert-info');
            },
            success: function (data) {
                if (data.success) {
                    message.html('<i class="fa fa-check"></i> ' + data.success).removeClass('alert-info').removeClass('alert-danger').addClass('alert-success');
                } else {
                    message.html('<i class="fa fa-times"></i> ' + data.error).removeClass('alert-success').removeClass('alert-info').addClass('alert-danger');
                }
                setTimeout(function () {
                    location.reload();
                }, 3000);
            },
            error: function () {
                message.html('<i class="fa fa-times"></i> '+display("ooops_something_went_wrong")).removeClass('alert-success').removeClass('alert-info').addClass('alert-danger');
                setTimeout(function () {
                    location.reload();
                }, 3000);
            }
        });
    });

});
