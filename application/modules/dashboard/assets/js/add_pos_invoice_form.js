"use strict";

function printDiv(divName) {

    var order_tbl = 0;
    $("#order-table tbody tr").each(function (i) {
        order_tbl = order_tbl + 1;
    });

    var bill_tbl = 0;
    $("#bill-table tbody tr").each(function (i) {
        bill_tbl = bill_tbl + 1;
    });

    if (order_tbl < 1) {
        alert('Please add product !');
    } else if (bill_tbl < 1) {
        alert('Please add product !');
    } else {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
}

function bank_info_show(payment_type) {
    if (payment_type.value == "1") {
        document.getElementById("bank_info_hide").style.display = "none";
    } else {
        document.getElementById("bank_info_hide").style.display = "block";
    }
}

function active_customer(status) {
    if (status == "payment_from_2") {
        document.getElementById("payment_from_2").style.display = "none";
        document.getElementById("payment_from_1").style.display = "block";
        document.getElementById("myRadioButton_2").checked = false;
        document.getElementById("myRadioButton_1").checked = true;
    } else {
        document.getElementById("payment_from_1").style.display = "none";
        document.getElementById("payment_from_2").style.display = "block";
        document.getElementById("myRadioButton_2").checked = false;
        document.getElementById("myRadioButton_1").checked = true;
    }
}

//Payment method toggle
$(document).ready(function () {
    "use strict";
    $(".payment_button").on('click',function () {
        $(".payment_method").toggle();

        //Select Option
        $("select.form-control:not(.dont-select-me)").select2({
            placeholder: "Select option",
            allowClear: true
        });
    });
});
