"use strict";
//Delete Brand 
$(".delete_brand").on('click', function()
{	
	var brand_id=$(this).attr('name');
	var csrf_test_name=  $("#CSRF_TOKEN").val();
	var x = confirm(display('are_you_sure_want_to_delete'));
	if (x==true){
	$.ajax
	   ({
			type: "POST",
			url: base_url+'dashboard/Cbrand/brand_delete',
			data: {brand_id:brand_id,csrf_test_name:csrf_test_name},
			cache: false,
			success: function(datas)
			{
				setTimeout("location.reload(true);",300);

			} 
		});
	}
});


