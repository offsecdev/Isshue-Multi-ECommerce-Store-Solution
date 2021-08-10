"use strict";
//Bank Information Show
function bank_info_show(payment_type) {
    if (payment_type.value == "1") {
        document.getElementById("bank_info_hide").style.display = "none";
    } else {
        document.getElementById("bank_info_hide").style.display = "block";
    }
}

//Active/Inactive customer
function active_customer(status) {
    if (status == "payment_from_2") {
        document.getElementById("payment_from_2").style.display = "none";
        document.getElementById("payment_from_1").style.display = "block";
        document.getElementById("myRadioButton_2").checked = false;
        document.getElementById("myRadioButton_1").checked = true;
        $('#customer_name_others').val('');
        $('#customer_name_others_address').val('');
    } else {
        document.getElementById("payment_from_1").style.display = "none";
        document.getElementById("payment_from_2").style.display = "block";
        document.getElementById("myRadioButton_2").checked = false;
        document.getElementById("myRadioButton_1").checked = true;
        document.getElementById("SchoolHiddenId").removeAttribute("value");
        $('#customer_name').val('');
    }
}

//Payment method toggle 
$(document).ready(function () {
    $(".payment_button").on('click',function () {
        $(".payment_method").toggle();

        //Select Option
        $("select.form-control:not(.dont-select-me)").select2({
            placeholder: "Select option",
            allowClear: true
        });
    });
});
