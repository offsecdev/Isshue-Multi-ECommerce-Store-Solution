// Print html element
function printDiv(divName) {
	"use strict";
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
	document.body.style.marginTop="0px";
    window.print();
    document.body.innerHTML = originalContents;
}
// Print html div Page
function printPageDiv(divName) {
	"use strict";
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
//Barcode Print
function barcodePrintDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    w = window.open();

    w.document.write(printContents);
    w.document.write('<scr' + 'ipt type="text/javascript">' + 'window.onload = function() { window.print(); window.close(); };' + '</sc' + 'ript>');

    w.document.close(); // necessary for IE >= 10
    w.focus(); // necessary for IE >= 10

    return true;
}
