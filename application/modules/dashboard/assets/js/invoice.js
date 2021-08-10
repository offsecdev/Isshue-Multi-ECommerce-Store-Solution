
function noteCheck(){
	"use strict";
	var add_note = $('#add_note').val();
	if (add_note) {
		return true;
	}else{
		alert(display('please_add_note'));
		return false;
	}
}


