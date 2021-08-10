
$(document).ready(function(){
    "use strict";
    var csrf_test_name=  $("#CSRF_TOKEN").val();

    var upload   = $("#upload");
    var download = $("#download");
    var dbImport = $("#import");
    var downloadUrl = base_url+"dashboard/data_synchronizer/ftp_download";
    var dbImportUrl = base_url+"dashboard/data_synchronizer/import";
    var uploadUrl = base_url+"dashboard/data_synchronizer/ftp_upload";
    var token = csrf_test_name+":"+csrf_test_name;
    var message  = $("#message");

    //download process
    download.on('click', function() {
        ajaxLoad(downloadUrl, token);
    });
    //import process
    dbImport.on('click', function() {
        ajaxLoad(dbImportUrl, token);
    });
    //upload process
    upload.on('click', function() {
        ajaxLoad(uploadUrl, token);
    });

    function ajaxLoad(URL, token)
    {
        $.ajax({
            url: URL,
            method: 'get',
            dataType: 'json', 
            data : token,
            beforeSend:function()
            {
                message.html('<i class="ti-settings fa fa-spin"></i> '+display("please_wait")).removeClass('hide').addClass('alert-info');  
            }, 
            success:function(data) 
            {
                if (data.success) {
                    message.html('<i class="fa fa-check"></i> '+data.success).removeClass('alert-info').removeClass('alert-danger').addClass('alert-success'); 
                } else {
                   message.html('<i class="fa fa-times"></i> '+data.error).removeClass('alert-success').removeClass('alert-info').addClass('alert-danger');  
                } 
                setTimeout(function(){
                    location.reload();
                }, 3000);
            }, 
            error: function()
            {
                message.html('<i class="fa fa-times"></i> '+display("ooops_something_went_wrong")).removeClass('alert-success').removeClass('alert-info').addClass('alert-danger');
                setTimeout(function(){
                    location.reload();
                }, 3000);
            }
        });   
    }
});
