"use strict";
//Delete Category 
$(".DeleteCategory").on('click', function()
{	
	var category_id=$(this).attr('name');
	var csrf_test_name=  $("#CSRF_TOKEN").val();
	var x = confirm(display('are_you_sure_want_to_delete'));
	if (x==true){
	$.ajax
	   ({
			type: "POST",
			url: base_url+'dashboard/Ccategory/category_delete',
			data: {category_id:category_id,csrf_test_name:csrf_test_name},
			cache: false,
			success: function(datas)
			{
				location.reload();
			} 
		});
	}
});
