"use strict";
//Delete Customer 
$(".deleteCustomer").on('click', function()
{	
	var customer_id=$(this).attr('name');
	var csrf_test_name=  $("#CSRF_TOKEN").val();
	var x = confirm(display('are_you_sure_want_to_delete'));
	if (x==true){
	$.ajax
   ({
		type: "POST",
		url: base_url+'dashboard/Ccustomer/customer_delete',
		data: {customer_id:customer_id,csrf_test_name:csrf_test_name},
		cache: false,
		success: function(datas)
		{
		} 
	});
	}
});
