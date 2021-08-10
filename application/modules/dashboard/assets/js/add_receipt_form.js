$(document).ready(function(){
	"use strict";
	$(".radioField").on('change', function(){
		var user_type = $("input:radio[name=payment_type]:checked").val();
	  if(user_type == 2){
		$(".checque_type").slideDown();
	  }else if(user_type == 1){
		$(".checque_type").slideUp();
	  }
	});
});
