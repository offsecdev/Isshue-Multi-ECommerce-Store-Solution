"use strict";
$('#product_id').on('change', function(e) {
    e.preventDefault();
    var product_id = $(this).val();
    var csrf_test_name=  $("#CSRF_TOKEN").val();
    $.ajax({
        type: "post",
        async: false,
        url: base_url+'dashboard/Creport/retrive_variant_by_product',
        data: {csrf_test_name:csrf_test_name,product_id: product_id},
        success: function(data) {
            if (data) {
                $("#variant_id").html(data);
            }else{
                $("#variant_id").html("Variant not found !");
            }
        },
        error: function() {
            alert('Request Failed, Please try again!');
        }
    });
});
