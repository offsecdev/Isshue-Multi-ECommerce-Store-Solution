"use strict";
//Delete product_review 
$(".delete_product_review").on('click', function()
{
	var product_review_id=$(this).attr('name');
	var csrf_test_name=  $("#CSRF_TOKEN").val();
	var x = confirm(display('are_you_sure_want_to_delete'));
	if (x==true){
	$.ajax
	   ({
			type: "POST",
			url: base_url+'dashboard/Cproduct_review/product_review_delete',
			data: {product_review_id:product_review_id,csrf_test_name:csrf_test_name},
			cache: false,
			success: function(datas)
			{
				setTimeout("location.reload(true);",300);

			} 
		});
	}
});
