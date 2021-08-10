"use strict";
var csrf_test_name=  $("#CSRF_TOKEN").val();

function edit_tax_name(id){
    var value = $('#tax_name_'+id).val();
    $.ajax({
        url: base_url+"dashboard/Ctax/update_tax",
        type: 'POST',
        data: {'csrf_test_name':csrf_test_name,'id':id,'value':value},
        success: function (data){
            toastr.success(data, " ", {
                "timeOut": "200",
                "extendedTImeout": "200"
            });
        },
        error: function (exc){
            toastr.warning("Failed");
        }
    });
}



$(".taxStatus").on('click', function() {
    if($(this).attr('checked'))
    {
        var tax_id = $(this).val();
        var tax_name = $('#tax_name_'+tax_id).val();
        $.post(base_url+'dashboard/Ctax/inactive_tax',
            {
                csrf_test_name:csrf_test_name,
                tax_id: tax_id,
                tax_name: tax_name
            },

            function(data, status){
                if (data == 1) {
                    toastr.success('Inactive successfully', " ", {
                        "timeOut": "200",
                        "extendedTImeout": "200"
                    });
                    location.reload();
                }
            });
    }
    else
    {
        var tax_id   = $(this).val();
        var tax_name = $('#tax_name_'+tax_id).val();
        $.post(base_url+'dashboard/Ctax/active_tax',
            {
                csrf_test_name:csrf_test_name,
                tax_id: tax_id,
                tax_name: tax_name
            },

            function(data, status){
                if (data == 1) {
                    toastr.success('Active successfully', " ", {
                        "timeOut": "200",
                        "extendedTImeout": "200"
                    });
                    location.reload();
                }
            });
    }
});

