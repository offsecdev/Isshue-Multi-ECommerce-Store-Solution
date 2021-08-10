
"use strict";
var csrf_test_name=  $("#CSRF_TOKEN").val();

//Product selection start
$('body').on('change', '#country', function(){
    var country_id = $(this).val();
    var csrf_token_ = $(this).val();
    $.ajax
    ({
        url: base_url+'web/customer/Customer_dashboard/select_city_country_id')?>",
        data: {csrf_test_name:csrf_test_name,country_id:country_id},
        type: "post",
        success: function(data)
        {
            $('#state').html(data);   
        } 
    });
});
