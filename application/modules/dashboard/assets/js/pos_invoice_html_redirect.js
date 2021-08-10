"use strict";
var return_form=document.getElementById('pos_place').value;

if(return_form === 'pos') {
	var printContents = document.getElementById('printableArea').innerHTML;

	var originalContents = document.body.innerHTML;

	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;

	setTimeout(function(){
		var base_url=document.getElementById('base_url').value;
	    window.location.href=base_url+'dashboard/Cinvoice/pos_invoice';
		}, 3000);
}
