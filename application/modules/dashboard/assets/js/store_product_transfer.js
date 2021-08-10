"use strict";
var csrf_test_name=  $("#CSRF_TOKEN").val();
//Select transfer to
$('body').on('change',"#store_id",function(event){
    event.preventDefault(); 
    
    var store_id=$('#store_id').val();
    if ( !store_id ) {
        alert(display('please_select_store'));
        return false;
    }
    $.ajax({
        url: base_url+'dashboard/Cstore/store_transfer_select',
        type: 'post',
        data: {store_id:store_id,csrf_test_name:csrf_test_name},
        success: function (result){
           var msg= JSON.parse(result);

            if (msg) {
                $("#transfer").html(msg['stores']);
                $("#product_name").html(msg['products']);
            }else{
                $("#transfer").html('');
                $("#product_name").html('');
            }
        },
        error: function (xhr, desc, err){
             alert('failed');
        }
    });        
});

$('body').on('change',"#product_name",function(event){
    event.preventDefault(); 
    var store_id=$('#store_id').val();
    var product_id=$('#product_name').val();

    if ( !store_id ) {
        alert(display('please_select_store'));
        return false;
    }
    $.ajax({
        url: base_url+'dashboard/Cstore/get_variant_by_store',
        type: 'post',
        data: {store_id:store_id,product_id:product_id,csrf_test_name:csrf_test_name},
        success: function (result){
            var res = JSON.parse(result);
            if (res['variant_html'] != '') {
                $("#variant").html(res['variant_html']);
            }else{
                $("#variant").html('');
            }
            
            if (res['variant_colorhtml'] != '') {
                $("#variant_color").html(res['variant_colorhtml']);
            }else{
                $("#variant_color").html('');
            }

        },
        error: function (xhr, desc, err){
             alert('failed');
        }
    });        
});



