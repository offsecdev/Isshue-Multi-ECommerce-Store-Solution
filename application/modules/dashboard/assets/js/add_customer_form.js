"use strict";
$('body').on('change', '#country', function(){
    var country_id = $(this).val();
    var csrf_test_name=  $("#CSRF_TOKEN").val();
    $.ajax
    ({
        url: base_url+'dashboard/Ccustomer/select_city_country_id',
        data: {csrf_test_name:csrf_test_name, country_id:country_id},
        type: "post",
        success: function(data)
        {
            $('#state').html(data);   
        } 
    });
});
