"use strict";
//Delete currency 
$(".delete_currency").on('click', function()
{	
	var currency_id=$(this).attr('name');
	var csrf_test_name=  $("#CSRF_TOKEN").val();
	var x = confirm(display('are_you_sure_want_to_delete'));
	if (x==true){
	$.ajax
	   ({
			type: "POST",
			url: base_url+'dashboard/Ccurrency/currency_delete',
			data: {currency_id:currency_id,csrf_test_name:csrf_test_name},
			cache: false,
			success: function(datas)
			{
				setTimeout("location.reload(true);",300);
			} 
		});
	}
});
