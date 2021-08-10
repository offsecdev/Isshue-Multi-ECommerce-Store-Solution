// Checkout page
$('body').on('click', '.customer_login', function () {
    let login_email = $('#login_email').val();
    let login_password = $('#login_password').val();
    let remember_me = $('#remember_me').val();

    if (login_email == 0 || login_password == 0) {
        Swal({
            type: 'warning',
            title: display('please_type_email_and_password')
        });
        return false;
    }
    $.ajax({
        type: "post",
        async: true,
        url: base_url+"web/customer/Login/checkout_login",
        data: {
            "csrf_test_name": CSRF_TOKEN,
            "login_email": login_email,
            "login_password": login_password,
            "remember_me": remember_me
    },
    success: function (data) {
        if (data === 'true') {
            swal(display('login_successfully'), "", "success");
            location.reload();
        } else {
            swal(display('wrong_username_or_password'), "", "warning");
            location.reload();
        }
    },
    error: function () {
        Swal({
            type: 'warning',
            title: display('request_failed')
        })
    }
});
})


$('body').on('change', '#country', function () {
    let country_id = $('#country').val();
    if (country_id === 0) {

        Swal({
            type: 'warning',
            title: display('please_select_country')
        });
        return false;
    }
    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/Home/retrive_district",
        data: {"csrf_test_name": CSRF_TOKEN, "country_id": country_id},
        success: function (data) {
            if (data) {
                $("#state").html(data);
            } else {
                $("#state").html('<p class="color_red">'+display("failed")+'</p>');
            }
        },
        error: function () {
            Swal({
                type: 'warning',
                title: display('request_failed')
            });

        }
    });
});

$('body').on('change', '#ship_country', function () {
    var country_id = $('#ship_country').val();
    if (country_id === 0) {

        Swal({
            type: 'warning',
            title: display('please_select_country')
        });
        return false;
    }
    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/Home/retrive_district",
        data: {"csrf_test_name": CSRF_TOKEN, "country_id": country_id},
        success: function (data) {
            if (data) {
                $("#ship_state").html(data);
            } else {
                $("#ship_state").html('<p class="color_red">'+display("failed")+'</p>');
            }
        },
        error: function () {
            Swal({
                type: 'warning',
                title: display('request_failed')
            });
        }
    });
});

var couponAmount = 0;
$('body').on('click', '.shipping_cost', function () {
    var cart_total_amount = 0;
    var shipping_cost = $(this).val();
    var ship_cost_name = $(this).attr('alt');
    var method_id = $(this).attr('id');
    cart_total_amount = $('#cart_total_amount').val(); //include tax
    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/Home/set_ship_cost_cart",
        data: {
            "csrf_test_name": CSRF_TOKEN,
            "shipping_cost": shipping_cost,
            "ship_cost_name": ship_cost_name,
            "method_id": method_id
        },
        success: function (data) {
            $('#shipCostRow').show();
            $('#set_cart_ship_name').html(ship_cost_name);
            $('#set_ship_cost').html(shipping_cost);
            let total_cost = +cart_total_amount + +shipping_cost - +couponAmount;
            $('#total_amount').html(parseFloat(total_cost).toFixed(2));
            $('#order_total_amount').val(parseFloat(total_cost).toFixed(2));
        },
        error: function () {
            Swal({
                type: 'warning',
                title: display('request_failed')
            });
        }
    });
});

var cart_total_amount = $('#cart_total_amount').val(); //include tax
$('input[type=radio]').attr('checked', false);
$('#shipCostRow').hide();
$('#couponAmountRow').hide();
$('#total_amount').html(parseFloat(cart_total_amount).toFixed(2));
$('#order_total_amount').val(parseFloat(cart_total_amount).toFixed(2));
var coupon_amnt = $('#coupon_amnt').val();
var coupon_message = $('#coupon_message').val();
var coupon_error_message = $('#coupon_error_message').val();


//check coupon amount
$('#coupon_value').on('click', function (e) {
    e.preventDefault();
    let couponInfo = $('#coupon_code').val();
    let coupon_code = $.trim(couponInfo);
    $.ajax({
        url: base_url + "web/home/apply_coupon",
        type: "post",
        data: {"csrf_test_name": CSRF_TOKEN, "coupon_code": coupon_code},
        success: function (data) {

            if (data == '1' || data == '2') {
                couponAmount = coupon_amnt;
                $('#set_coupon_price').html(couponAmount);
                $('#couponAmountRow').show();
                var afterCouponTotalAmount = parseFloat(cart_total_amount).toFixed(2) - +parseFloat(couponAmount).toFixed(2);
                $('#total_amount').html(parseFloat(afterCouponTotalAmount).toFixed(2));
                $('#order_total_amount').val(parseFloat(afterCouponTotalAmount).toFixed(2));
                $('#coupon_error').html(coupon_message)
                $('#coupon_error_text_color').css({'color': '#155724'});
            } else {
                $('#coupon_error').html(coupon_error_message);
                $('#coupon_error_text_color').css({'color': '#721c24'});
            }
        }
    });

});

$('body').on('click', '.sw-btn-next', function () {
    $.ajax({
        type: "get",
        async: true,
        url: base_url + "web/Home/check_product_store",
        success: function (data) {
            if (data === 'no') {
                Swal({
                    type: 'warning',
                    title: display('not_enough_product_in_stock')
                });
                window.location.href = base_url + "view_cart";
            }
        },
        error: function () {
            Swal({
                type: 'warning',
                title: display('request_failed')
            })
        }
    });
});

//Shipping to different address
$('#diff_ship_adrs').on("click", function () {
    var check = $('[name="diff_ship_adrs"]:checked').length;
    if (check > 0) {
        $('input[name="diff_ship_adrs"]').attr("checked", "checked");
    } else {
        $('input[name="diff_ship_adrs"]').removeAttr('checked');
    }
});

//Privacy policy
$('#privacy_policy').on("click", function () {
    var check = $('[name="privacy_policy"]:checked').length;
    if (check > 0) {
        $('input[name="privacy_policy"]').attr("checked", "checked");
    } else {
        $('input[name="privacy_policy"]').removeAttr('checked');
    }
});


//Onkeyup change session value
$('body').on('keyup click change', '#first_name,#last_name,#customer_email,#customer_mobile,#customer_address_1,' +
    '#customer_address_2,#company,#city,#zip,#country,#state,#ac_pass,#privacy_policy,.shipping_cost,' +
    '#ship_first_name,#ship_last_name,#ship_customer_email,#ship_mobile,#ship_country,#ship_address_1,#ship_address_2,#ship_city,#ship_state,#ship_zip,#ship_company,#order_details,#creat_ac', function () {

    var shipping_cost = $('input[name=shipping_cost]:checked').val();
    var ship_cost_name = $('input[name=shipping_cost]:checked').attr('alt');
    var method_id = $('input[name=shipping_cost]:checked').attr('id');

    //Ship and billing info
    var first_name = $('#first_name').val();
    var last_name = $('#last_name').val();
    var customer_email = $('#customer_email').val();
    var customer_mobile = $('#customer_mobile').val();
    var customer_address_1 = $('#customer_address_1').val();
    var customer_address_2 = $('#customer_address_2').val();
    var company = $('#company').val();
    var city = $('#city').val();
    var zip = $('#zip').val();
    var country = $('#country').val();
    var state = $('#state').val();
    var ac_pass = $('#ac_pass').val();
    var privacy_policy = $('#privacy_policy').attr("checked") ? 1 : 0;
    var creat_ac = $('#creat_ac').attr("checked") ? 1 : 0;

    var ship_first_name = $('#ship_first_name').val();
    var ship_last_name = $('#ship_last_name').val();
    var ship_company = $('#ship_company').val();
    var ship_mobile = $('#ship_mobile').val();
    var ship_email = $('#ship_customer_email').val();
    var ship_address_1 = $('#ship_address_1').val();
    var ship_address_2 = $('#ship_address_2').val();
    var ship_city = $('#ship_city').val();
    var ship_zip = $('#ship_zip').val();
    var ship_country = $('#ship_country').val();
    var ship_state = $('#ship_state').val();
    var payment_method = $('input[name=\'payment_method\']:checked').val();
    var order_details = $('#order_details ').val();
    var diff_ship_adrs = $('#diff_ship_adrs').attr("checked") ? 1 : 0;
    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/Home/set_ship_cost_cart",
        data: {
            "csrf_test_name": CSRF_TOKEN,
            "shipping_cost": shipping_cost,
            "ship_cost_name": ship_cost_name,
            "method_id": method_id,
            "first_name": first_name,
            "last_name": last_name,
            "customer_email": customer_email,
            "customer_mobile": customer_mobile,
            "customer_address_1": customer_address_1,
            "customer_address_2": customer_address_2,
            "company": company,
            "city": city,
            "zip": zip,
            "country": country,
            "state": state,
            "ac_pass": ac_pass,
            "privacy_policy": privacy_policy,
            "creat_ac": creat_ac,
            "ship_first_name": ship_first_name,
            "ship_last_name": ship_last_name,
            "ship_company": ship_company,
            "ship_mobile": ship_mobile,
            "ship_email": ship_email,
            "ship_address_1": ship_address_1,
            "ship_address_2": ship_address_2,
            "ship_city": ship_city,
            "ship_zip": ship_zip,
            "ship_country": ship_country,
            "ship_state": ship_state,
            "payment_method": payment_method,
            "order_details": order_details,
            "diff_ship_adrs": diff_ship_adrs,
        },
        success: function (data) {
            return true;
        },
        error: function () {

        }
    });
});
$("#validateForm").validate({
    errorElement: 'span',
    errorClass: 'help-block',
    rules: {
        first_name: {
            required: true
        },
        ship_first_name: {
            required: true
        },
        last_name: {
            required: true
        },
        ship_last_name: {
            required: true
        },
        customer_mobile: {
            required: true,
        },
        ship_mobile: {
            required: true,
        },
        country: {
            required: true,
        },
        ship_country: {
            required: true,
        },
        customer_address_1: {
            required: true,
        },
        ship_address_1: {
            required: true,
        },
        state: {
            required: true,
        },
        ship_state: {
            required: true,
        },
    },
    messages: {
        first_name: {
            required: display('first_name_is_required'),
        },
        ship_first_name: {
            required: display('first_name_is_required'),
        },
        last_name: {
            required: display('last_name_is_required'),
        },
        ship_last_name: {
            required: display('last_name_is_required'),
        },
        customer_mobile: {
            required: display('mobile_is_required'),
        },
        ship_mobile: {
            required: display('mobile_is_required'),
        },
        country: {
            required: display('country_is_required'),
        },
        ship_country: {
            required: display('country_is_required'),
        },
        customer_address_1: {
            required: display('address_is_required'),
        },
        ship_address_1: {
            required: display('address_is_required'),
        },
        state: {
            required: display('state_is_required'),
        },
        ship_state: {
            required: display('state_is_required'),
        },
    },
    errorPlacement: function (error, element) {
        if (error) {
            $(element).parent().attr('class', 'form-group has-error');
            $(element).parent().append(error);
        } else {
            $(element).parent().attr('class', 'form-group');
        }
    },
    success: function (error, element) {
        $(element).parent().attr('class', 'form-group');
    }
});
