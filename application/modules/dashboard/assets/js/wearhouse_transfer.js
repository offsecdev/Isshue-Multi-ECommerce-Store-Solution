"use strict";
//Select transfer to
$('body').on('change',"#transfer_to,#wearhouse_id",function(event){
    event.preventDefault(); 
    var transfer_id=$('#transfer_to').val();
    var wearhouse_id=$('#wearhouse_id').val();
    var csrf_test_name=  $("#CSRF_TOKEN").val();

    if ( !wearhouse_id ) {
        alert(display('please_select_wearhouse'));
        return false;
    }
    $.ajax({
        url: base_url+'dashboard/Cwearhouse/wearhouse_transfer_select',
        type: 'post',
        data: {transfer_id:transfer_id,wearhouse_id:wearhouse_id,csrf_test_name:csrf_test_name},
        success: function (msg){
            if (msg) {
                $("#transfer").css('display','block');
                $("#transfer").html(msg);
            }else{
                $("#transfer").html('');
            }
        },
        error: function (xhr, desc, err){
             alert('failed');
        }
    });        
});
//Product select by ajax end
