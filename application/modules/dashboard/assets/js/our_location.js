"use strict";
//Delete our_location 
$(".delete_our_location").on('click', function()
{	
	var position=$(this).attr('name');
	var csrf_test_name=  $("#CSRF_TOKEN").val();
	var x = confirm(display('are_you_sure_want_to_delete'));
	if (x==true){
	$.ajax
	   ({
			type: "POST",
			url: base_url+'dashboard/Cour_location/our_location_delete',
			data: {position:position,csrf_test_name:csrf_test_name},
			cache: false,
			success: function(datas)
			{
				setTimeout("location.reload(true);",100);

			} 
		});
	}
});
