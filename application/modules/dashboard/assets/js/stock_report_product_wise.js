"use strict";
$('#supplier_id').on('change', function(e) {
    var supplier_id = $(this).val();
    var csrf_test_name=  $("#CSRF_TOKEN").val();
    $.ajax({
        type: "post",
        async: false,
        url: base_url+'dashboard/Creport/get_product_by_supplier',
        data: {csrf_test_name:csrf_test_name,supplier_id: supplier_id},
        success: function(data) {
            if (data) {
                $("#product_id").html(data);
            }else{
                $("#product_id").html("Product not found !");
            }
        },
        error: function() {
            alert('Request Failed, Please try again!');
        }
    });
});
