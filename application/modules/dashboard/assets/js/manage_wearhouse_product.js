"use strict";
//Delete wearhouse 
$(".delete_wearhouse_product").on('click', function()
{	
	var csrf_test_name=  $("#CSRF_TOKEN").val();
	var transfer_id=$(this).attr('name');
	var x = confirm(display('are_you_sure_want_to_delete'));
	if (x==true){
	$.ajax
	   ({
			type: "POST",
			url: '',
			data: {transfer_id:transfer_id,csrf_test_name:csrf_test_name},
			cache: false,
			success: function(datas)
			{
				setTimeout("location.reload(true);",300);

			} 
		});
	}
});

