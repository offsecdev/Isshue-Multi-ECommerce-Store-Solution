"use strict";
var csrf_test_name=  $("#CSRF_TOKEN").val();
//Delete wishlist 
$(".delete_wishlist").on('click',function()
{	
	var wishlist_id=$(this).attr('name');
	var x = confirm(display('are_you_sure_want_to_delete'));
	if (x==true){
	$.ajax
	   ({
			type: "POST",
			url: base_url+'web/customer/Customer_dashboard/wishlist_delete',
			data: {wishlist_id:wishlist_id,csrf_test_name:csrf_test_name},
			cache: false,
			success: function(datas)
			{
				setTimeout("location.reload(true);",100);

			} 
		});
	}
});
