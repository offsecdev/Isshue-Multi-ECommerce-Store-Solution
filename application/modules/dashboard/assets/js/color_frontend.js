"use strict";
//Delete Customer 
$("#theme_name").on('change', function()
{	
	var theme_name=$(this).val();
	var csrf_test_name=  $("#CSRF_TOKEN").val();

	$.ajax ({
		type: "POST",
		url: base_url+'dashboard/csoft_setting/ajax_theme_color',
		data: {theme_name:theme_name,csrf_test_name:csrf_test_name},
		success: function(res)
		{
			var cres = JSON.parse(res);
			if(cres != ''){
				$('#color1').val(cres['color1']);
				$('#color2').val(cres['color2']);
				$('#color3').val(cres['color3']);
				$('#color4').val(cres['color4']);
				$('#color5').val(cres['color5']);
			}
		} 
	});
});

