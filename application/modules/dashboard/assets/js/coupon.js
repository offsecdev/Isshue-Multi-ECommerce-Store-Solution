"use strict";
//Delete coupon 
$(".delete_coupon").on('click', function()
{	
	var coupon_id=$(this).attr('name');
	var csrf_test_name=  $("#CSRF_TOKEN").val();
	var x = confirm(display('are_you_sure_want_to_delete'));
	if (x==true){
	$.ajax
	   ({
			type: "POST",
			url: base_url+'dashboard/Ccoupon/coupon_delete',
			data: {csrf_test_name:csrf_test_name,coupon_id:coupon_id},
			cache: false,
			success: function(datas)
			{
				setTimeout("location.reload(true);",100);

			} 
		});
	}
});
