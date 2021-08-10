"use strict";
//Delete wishlist 
$(".delete_wishlist").on('click', function()
{	
	var wishlist_id=$(this).attr('name');
	var csrf_test_name=  $("#CSRF_TOKEN").val();
	var x = confirm(display('are_you_sure_want_to_delete'));
	if (x==true){
	$.ajax
	   ({
			type: "POST",
			url: base_url+'dashboard/Cwishlist/wishlist_delete',
			data: {csrf_test_name:csrf_test_name,wishlist_id:wishlist_id},
			cache: false,
			success: function(datas)
			{
				setTimeout("location.reload(true);",100);

			} 
		});
	}
});


