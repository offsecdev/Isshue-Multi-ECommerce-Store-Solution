"use strict";
//Delete store 
$(".delete_store_product").on('click', function()
{	
	var store_id=$(this).attr('name');
	var csrf_test_name=  $("#CSRF_TOKEN").val();

	var x = confirm(display('are_you_sure_want_to_delete'));
	if (x==true){
	$.ajax
	   ({
			type: "POST",
			url: base_url+'dashboard/Cstore/store_product_delete',
			data: {store_id:store_id,csrf_test_name:csrf_test_name},
			cache: false,
			success: function(datas)
			{
				setTimeout("location.reload(true);",300);

			} 
		});
	}
});



