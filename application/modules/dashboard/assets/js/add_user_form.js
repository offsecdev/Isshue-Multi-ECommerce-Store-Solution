"use strict";
//Active/Inactive store
$('body').on('change', '#user_type', function() {
    var user_type = $(this).val();
    if (user_type == 4) {
        document.getElementById("payment_from_1").style.display="block";
    }else{
        document.getElementById("payment_from_1").style.display="none";
    }
});
