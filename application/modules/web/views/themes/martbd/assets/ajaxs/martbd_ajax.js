"use strict";

var CSRF_TOKEN = $("#CSRF_TOKEN").val();

var base_url = $("#base_url").val();

var company_name = $('#company_name').val();

var map_langitude = $('#map_langitude').val();

var map_latitude = $('#map_latitude').val();

var uri_segment = $('#uri_segment').val();

var language_id = $('#language_id').val();
var myResponse = "";
$.ajax({
    url: base_url + 'assets/js/language.json',
    async: false,
    method: 'post',
    dataType: 'json',
    global: false,
    contentType: 'application/json',
    success: function(data) {
        var obj = JSON.stringify(data);
        myResponse = obj;
    }
});

var getPhrase = JSON.parse(myResponse);

function display(item) {
    if (typeof(getPhrase[item]) != "undefined" &&
        getPhrase[item] !== null) {
        return getPhrase[item][language_id];
    }
    return false;
}

$('#sst,.reduced,.increase').on("change click", function() {
    var product_quantity = $('#sst').val();
    var product_id = $('#product_id').val();
    var variant = $('#select_size1').val();
    var variant_color = $('[name="select_color"]:checked').val();

    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/Product/check_quantity_wise_stock",
        data: {
            "csrf_test_name": CSRF_TOKEN,
            "product_quantity": product_quantity,
            "product_id": product_id,
            "variant": variant,
            'variant_color': variant_color
        },
        success: function(data) {
            if (data == 'no') {
                Swal({
                    type: 'warning',
                    title: display('not_enough_product_in_stock')
                });
                return false;
            }
            if (data == 'yes') {
                return true;
            }
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            });
        }
    });
});

function select_variant(product_id) {

    var variant_id = $('#select_size1').val();
    var variant_color = $('[name="select_color"]:checked').val();

    $.ajax({
        type: "post",
        async: true,
        url: base_url + 'web/Product/check_2d_variant_info',
        data: {
            'csrf_test_name': CSRF_TOKEN,
            'variant_id': variant_id,
            'product_id': product_id,
            'variant_color': variant_color
        },
        success: function(res) {

            var result = JSON.parse(res);
            if (result[0] == 'yes') {
                $('.var_amount').html(result[1]);
                if (parseInt(result[3]) > 0) {
                    $('.regular_price').html(result[2]);
                    $('.save_perct').html(result[3]);
                    $('.price_discount').show();
                } else {
                    $('.price_discount').hide();
                }
                return true;
            } else {
                Swal({
                    type: 'warning',
                    title: display('variant_not_available')
                });
                $(".product_size").load(location.href + " .product_size>*", "");
                return false;
            }
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            });
        }
    });

}

// Select stock via color variant
function select_color_variant(product_id, variant_color, default_variant) {
    var variant_id = $('#select_size1').val();
    if (variant_id == '') {
        variant_id = default_variant;
    }
    $.ajax({
        type: "post",
        async: true,
        url: base_url + 'web/Product/check_2d_variant_info',
        data: {
            'csrf_test_name': CSRF_TOKEN,
            'product_id': product_id,
            'variant_id': variant_id,
            'variant_color': variant_color
        },
        success: function(res) {

            var result = JSON.parse(res);
            if (result[0] == 'yes') {
                $('.var_amount').html(result[1]);
                if (parseInt(result[3]) > 0) {
                    $('.regular_price').html(result[2]);
                    $('.save_perct').html(result[3]);
                    $('.price_discount').show();
                } else {
                    $('.price_discount').hide();
                }
                return true;
            } else {
                Swal({
                    type: 'warning',
                    title: display('variant_not_available')
                });
                return false;
            }

        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            });
        }
    });

}

// SEt color variant ID
$('.product_colors').on('change', function() {
    var variant_id = $(this).val();
    $('#color_variant_id').val(variant_id);
    $('#color_' + variant_id).attr('checked', 'checked');
});

//Add to cart by ajax
function cart_btn(product_id) {
    var qnty = $('#sst').val();
    var variant = $('#select_size1').val();
    var variant_color = $('#color_variant_id').val();
    var product_quantity = qnty;
    if (product_id == 0) {

        Swal({
            type: 'warning',
            title: display('ooops_something_went_wrong')
        });
        return false;
    }
    if (qnty <= 0) {

        Swal({
            type: 'warning',
            title: display('please_keep_quantity_up_to_zero')
        });
        return false;
    }
    if (variant != 'undefine') {
        if (variant <= 0) {

            Swal({
                type: 'warning',
                title: display('please_select_product_size')
            });
            return false;
        }
    }

    //before add to cart check product stock
    $.ajax({
        type: "POST",
        async: true,
        url: base_url + "web/Product/check_quantity_wise_stock",
        data: {
            'csrf_test_name': CSRF_TOKEN,
            'product_quantity': product_quantity,
            'product_id': product_id,
            'variant': variant,
            'variant_color': variant_color
        },
        success: function(data) {
            if (data == 'no') {
                Swal({
                    type: 'warning',
                    title: display('not_enough_product_in_stock')
                });
                return false;
            }
            if (data == 'yes') {
                $.ajax({
                    type: "POST",
                    async: true,
                    url: base_url + 'web/Home/add_to_cart_details',
                    data: {
                        'csrf_test_name': CSRF_TOKEN,
                        'product_id': product_id,
                        'qnty': qnty,
                        'variant': variant,
                        'variant_color': variant_color
                    },
                    success: function(data) {
                        $("#tab_up_cart").load(location.href + " #tab_up_cart>*", "");

                        Swal({
                            type: 'success',
                            title: display('product_added_to_cart')
                        })
                    },
                    error: function() {
                        Swal({
                            type: 'warning',
                            title: display('request_failed')
                        })
                    }
                });
            }
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            })
        }
    });
}

// compsrison btn start
function comparison_btn(product_id) {
    if (product_id == 0) {
        Swal({
            type: 'warning',
            title: display('ooops_something_went_wrong')
        });
        return false;
    }
    $.ajax({
        type: "POST",
        async: true,
        url: base_url + 'web/Home/add_to_comparison_details',
        data: {
            'csrf_test_name': CSRF_TOKEN,
            'product_id': product_id
        },
        success: function(data) {
            $("#tab_up_comparison").load(location.href + " #tab_up_comparison>*", "");

            Swal({
                type: 'success',
                title: display('product_added_to_compare')
            })
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            })
        }
    });
}

$("body").on("click", ".delete_comparison_item", function(e) {
    e.preventDefault();
    if (!confirm(display("are_you_sure_want_to_delete"))) {
        return false;
    }
    var comparison_id = $(this).attr("name");
    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/Home/delete_comparison/",
        data: {
            comparison_id: comparison_id,
            csrf_test_name: CSRF_TOKEN
        },
        success: function(data) {
            $("#tab_up_comparison").load(location.href + " #tab_up_comparison>*", "");
        },
        error: function() {
            Swal({
                type: "warning",
                title: display('request_failed')
            });
        }
    });
});

$("body").on("click", ".delete_comparison", function(e) {
    e.preventDefault();
    if (!confirm(display("are_you_sure_want_to_delete"))) {
        return false;
    }
    var comparison_id = $(this).attr("name");
    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/Home/delete_comparison/",
        data: {
            comparison_id: comparison_id,
            csrf_test_name: CSRF_TOKEN
        },
        success: function(data) {
            window.location.reload();
        },
        error: function() {
            Swal({
                type: "warning",
                title: display('request_failed')
            });
        }
    });
});

//    check existing email when register user
$('#user_email').on('blur', function() {
    var user_email = $(this).val();
    $.ajax({
        type: "post",
        async: true,
        url: base_url + 'web/customer/signup/check_existing_user',
        data: {
            'csrf_test_name': CSRF_TOKEN,
            'user_email': user_email
        },
        success: function(data) {
            if (data == 1) {
                Swal({
                    type: 'warning',
                    title: display('already_exists')
                });

                $('#email_warning').html(display('this_email_already_exists'));
                $('#email_warning').css({
                    'color': 'red'
                });
                $('#create_account_btn').prop('disabled', true);
                return false;
            } else {
                $('#email_warning').hide();
                $('#create_account_btn').prop('disabled', false);
            }
        }
    });
});

//Add to cart by ajax
function add_to_cart(id) {
    var product_id = $('#product_id_' + id).val();
    var price = $('#price_' + id).val();
    var discount = $('#discount_' + id).val();
    var qnty = $('#qnty_' + id).val();
    var image = $('#image_' + id).val();
    var name = $('#name_' + id).val();
    var model = $('#model_' + id).val();
    var supplier_price = $('#supplier_price_' + id).val();
    var cgst = $('#cgst_' + id).val();
    var cgst_id = $('#cgst_id_' + id).val();
    var sgst = $('#sgst_' + id).val();
    var sgst_id = $('#sgst_id_' + id).val();
    var igst = $('#igst_' + id).val();
    var igst_id = $('#igst_id_' + id).val();

    if (product_id == 0) {

        Swal({
            type: 'warning',
            title: display('ooops_something_went_wrong')
        });
        return false;
    }
    $.ajax({
        type: "post",
        async: true,
        url: base_url + 'web/Home/add_to_cart',
        data: {
            'csrf_test_name': CSRF_TOKEN,
            'product_id': product_id,
            'price': price,
            'discount': discount,
            'qnty': qnty,
            'image': image,
            'name': name,
            'model': model,
            'supplier_price': supplier_price,
            'cgst': cgst,
            'cgst_id': cgst_id,
            'sgst': sgst,
            'sgst_id': sgst_id,
            'igst': igst,
            'igst_id': igst_id,
        },
        beforeSend: function() {
            $('.preloader').html("<img src='" + base_url + 'assets/website/image/loader.gif' + "'");
        },
        success: function(data) {
            $("#tab_up_cart").load(location.href + " #tab_up_cart>*", "");
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            })
        }
    });
}

//Add to cart by ajax
function add_to_cart_item(product_id, product_name = 'p', default_variant = '', variant_price = '') {

    if ((default_variant == '') || (variant_price != '')) {
        window.location.replace(base_url + "product/" + product_name + "/" + product_id);
        return false;
    }

    var variant = default_variant;
    var qnty = 1;

    var product_quantity = qnty;
    if (product_id == 0) {

        Swal({
            type: 'warning',
            title: display("ooops_something_went_wrong")
        });
        return false;
    }
    if (qnty <= 0) {
        Swal({
            type: 'warning',
            title: display("please_keep_quantity_up_to_zero")
        });
        return false;
    }

    //before add to cart check product stock
    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/Product/check_quantity_wise_stock",
        data: {
            "csrf_test_name": CSRF_TOKEN,
            "product_quantity": product_quantity,
            "product_id": product_id,
            'variant': variant
        },
        success: function(data) {
            if (data == 'no') {
                Swal({
                    type: 'warning',
                    title: display("not_enough_product_in_stock")
                })
                return false;
            }
            if (data == 'yes') {
                $.ajax({
                    type: "post",
                    async: true,
                    url: base_url + "web/Home/add_to_cart_details",
                    data: {
                        "csrf_test_name": CSRF_TOKEN,
                        "product_id": product_id,
                        "qnty": qnty,
                        "variant": variant
                    },
                    success: function(data) {
                        $("#tab_up_cart").load(location.href + " #tab_up_cart>*", "");
                        if (default_variant === 'buy') {
                            window.location.replace(base_url + "checkout");
                        }
                        Swal({
                            type: 'success',
                            title: display("product_added_to_cart")
                        })
                    },
                    error: function() {
                        Swal({
                            type: 'warning',
                            title: display("request_failed")
                        })
                    }
                });
            }
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display("request_failed")
            })
        }
    });
}


//===========change language=======
$("body").on("change", "#change_language", function() {
    var language = $("#change_language").val();

    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/Home/change_language",
        data: {
            'csrf_test_name': CSRF_TOKEN,
            'language': language
        },
        success: function(data) {
            console.log(data);
            if (data == 2) {
                location.reload();
            } else {
                location.reload();
            }
        },
        error: function() {
            Swal({
                type: "warning",
                title: display('request_failed')
            });
        }
    });
});


//Change currency ajax
$('body').on('change', '#change_currency', function() {
    var currency_id = $('#change_currency').val();
    $.ajax({
        type: "post",
        async: true,
        url: base_url + 'web/Home/change_currency',
        data: {
            'csrf_test_name': CSRF_TOKEN,
            'currency_id': currency_id
        },
        success: function(data) {
            if (data == 2) {
                location.reload();
            } else {
                location.reload();
            }
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            })
        }
    });
});


//=====================Product delete from cart by ajax

$("body").on("click", ".delete_cart_item", function() {
    if (!confirm(display("are_you_sure_want_to_delete"))) {
        return false;
    }
    var row_id = $(this).attr("name");
    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/Home/delete_cart/",
        data: {
            row_id: row_id,
            csrf_test_name: CSRF_TOKEN
        },
        success: function(data) {
            $("#tab_up_cart").load(location.href + " #tab_up_cart>*", "");
        },
        error: function() {
            Swal({
                type: "warning",
                title: display('request_failed')
            });
        }
    });
});


//===============Newsletter ajax code start

$("#sub_email").keypress(function(e) {
    if (e.which == 13) {
        $("#smt_btn").click();
    }
});
$("body").on("click", "#smt_btn", function(e) {
    e.preventDefault();

    var sub_email = $("#sub_email").val();
    var CSRF_TOKEN = $('#CSRF_TOKEN').val();

    var base_url = $("#base_url").val();
    if (sub_email == 0) {
        Swal({
            type: "warning",
            title: display('please_enter_email')
        });
        return false;
    }
    if (!validateEmail(sub_email)) {
        Swal({
            type: "warning",
            title: display('please_enter_email')
        });
        return false;
    } else {
        $.ajax({
            type: "POST",
            url: base_url + 'web/home/add_subscribe',
            data: {
                'csrf_test_name': CSRF_TOKEN,
                'sub_email': sub_email
            },
            success: function(data) {
                if (data == parseInt(2)) {
                    Swal({
                        type: 'success',
                        title: display('subscribe_successfully')
                    });
                    $("#sub_msg").html('<p class="sub_msg_success">' + display('subscribe_successfully') + '</p>');
                    $('#sub_msg').fadeOut(4000, function() {
                        $(this).remove();
                    });
                    $("#sub_email").val(" ");
                } else {

                    $("#sub_msg").html("<p class='color_red'>" + display("failed_try_again") + "</p>");
                    $("#sub_msg").fadeOut(4000, function() {
                        $(this).remove();
                    });
                    $("#sub_email").val(" ");
                }
            },
            error: function() {
                Swal({
                    type: "warning",
                    title: display('request_failed')
                });
            }
        });
    }
});


$('body').on('click', '.customer_login', function() {
    let login_email = $('#login_email').val();
    let login_password = $('#login_password').val();
    let remember_me = $('#remember_me').val();

    if (login_email == 0 || login_password == 0) {
        Swal({
            type: "warning",
            title: display('please_type_email_and_password')
        });
        return false;
    }
    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/customer/Login/checkout_login",
        data: {
            "csrf_test_name": CSRF_TOKEN,
            "login_email": login_email,
            "login_password": login_password,
            "remember_me": remember_me
        },
        success: function(data) {
            if (data === 'true') {
                swal(display('login_successfully'), "", "success");
                location.reload();
            } else {
                swal(display('wrong_username_or_password'), "", "warning");
                location.reload();
            }
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            })
        }
    });
});


$('body').on('change', '#country', function() {
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
        data: {
            "csrf_test_name": CSRF_TOKEN,
            "country_id": country_id
        },
        success: function(data) {
            if (data) {
                $("#state").html(data);
            } else {
                $("#state").html('<p class="color_red">' + display("failed") + '</p>');
            }
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            });

        }
    });
});


$('body').on('change', '#ship_country', function() {
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
        data: {
            "csrf_test_name": CSRF_TOKEN,
            "country_id": country_id
        },
        success: function(data) {
            if (data) {
                $("#ship_state").html(data);
            } else {
                $("#ship_state").html('<p class="color_red">' + display("failed") + '</p>');
            }
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            });
        }
    });
});


var couponAmount = 0;
$('body').on('click', '.shipping_cost', function() {
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
        success: function(data) {
            $('#shipCostRow').show();
            $('#set_cart_ship_name').html(ship_cost_name);
            $('#set_ship_cost').html(shipping_cost);
            let total_cost = +cart_total_amount + +shipping_cost - +couponAmount;
            $('#total_amount').html(parseFloat(total_cost).toFixed(2));
            $('#order_total_amount').val(parseFloat(total_cost).toFixed(2));
        },
        error: function() {
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
$('#coupon_value').on('click', function(e) {
    e.preventDefault();
    let couponInfo = $('#coupon_code').val();
    let coupon_code = $.trim(couponInfo);
    $.ajax({
        url: base_url + "web/home/apply_coupon_for_discount",
        type: "post",
        data: {
            "csrf_test_name": CSRF_TOKEN,
            "coupon_code": coupon_code
        },
        success: function(res) {
            var result = res.split('|');
            if (result[0] == 'success') {

                couponAmount = result[1];
                $('#couponAmountRow').show();
                $('#set_coupon_price').text(couponAmount);
                var afterCouponTotalAmount = parseFloat(cart_total_amount).toFixed(2) - parseFloat(couponAmount).toFixed(2);
                $('#total_amount').html(parseFloat(afterCouponTotalAmount).toFixed(2));
                $('#order_total_amount').val(parseFloat(afterCouponTotalAmount).toFixed(2));
                $('#coupon_error').html(result[2]);
                $('#coupon_error_text_color').css({
                    'color': '#155724'
                });

            } else {
                $('#coupon_error').html(result[1]);
                $('#coupon_error_text_color').css({
                    'color': '#155724'
                });
            }
        },
        error: function() {
            alert('Error found!');
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
    errorPlacement: function(error, element) {
        if (error) {
            $(element).parent().attr('class', 'form-group has-error');
            $(element).parent().append(error);
        } else {
            $(element).parent().attr('class', 'form-group');
        }
    },
    success: function(error, element) {
        $(element).parent().attr('class', 'form-group');
    }
});


$('body').on('click', '.sw-btn-next', function() {
    $.ajax({
        type: "get",
        async: true,
        url: base_url + "web/Home/check_product_store",
        success: function(data) {
            if (data === 'no') {
                Swal({
                    type: 'warning',
                    title: display('not_enough_product_in_stock')
                });
                window.location.href = base_url + "view_cart";
            }
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            })
        }
    });

});


//Shipping to different address
$('#diff_ship_adrs').on("click", function() {
    var check = $('[name="diff_ship_adrs"]:checked').length;
    if (check > 0) {
        $('input[name="diff_ship_adrs"]').attr("checked", "checked");
    } else {
        $('input[name="diff_ship_adrs"]').removeAttr('checked');
    }
});

//Privacy policy
$('#privacy_policy').on("click", function() {
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
    '#ship_first_name,#ship_last_name,#ship_customer_email,#ship_mobile,#ship_country,#ship_address_1,#ship_address_2,#ship_city,#ship_state,#ship_zip,#ship_company,#order_details,#creat_ac',
    function() {

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
            success: function(data) {
                return true;
            },
            error: function() {

            }
        });
    });


/*------------------------------------
        Price range slide
        -------------------------------------- */
var price_min_value = $("#price_min_value").val();
var price_max_value = $("#price_max_value").val();
var from_price = $("#from_price").val();
var to_price = $("#to_price").val();
var default_currency_icon = $("#default_currency_icon").val();

$(".price-range").ionRangeSlider({
    type: "double",
    grid: true,
    min: price_min_value,
    max: price_max_value,
    from: (from_price == 0) ? "null" : from_price,
    to: (to_price == 0) ? "null" : to_price,
    prefix: default_currency_icon,
    onChange: function(data) {
        var pattern = /[?]/;
        var URL = location.search;
        var fullURL = document.URL;

        if (pattern.test(URL)) {
            var $_GET = {};
            if (document.location.toString().indexOf('?') !== -1) {
                var query = document.location
                    .toString()
                    // get the query string
                    .replace(/^.*?\?/, '')
                    // and remove any existing hash string (thanks, @vrijdenker)
                    .replace(/#.*$/, '')
                    .split('&');

                for (var i = 0, l = query.length; i < l; i++) {
                    var aux = decodeURIComponent(query[i]).split('=');
                    $_GET[aux[0]] = aux[1];
                }
            }

            //Get from value by get method
            if ($_GET['price']) {
                var fullURL = window.location.href.split('?')[0];
                var url = window.location.search;
                url = url.replace("price=" + $_GET['price'], 'price=' + data.from + '-' + data.to);
                window.location.href = fullURL + url;
            } else {
                var url = window.location.search;
                window.location.href = url + '&price=' + data.from + '-' + data.to;
            }

        } else {
            var fullURL = window.location.href.split('?')[0];
            window.location.href = fullURL.split('?')[0] + '?price=' + data.from + '-' + data.to
        }
    }
});
/*------------------------------------
Product search by size
-------------------------------------- */
$('body').on('click', '.size1', function() {
    var size_location = $(this).val();
    window.location.href = size_location;
});
/*------------------------------------
Sorting product by category
-------------------------------------- */
$('#popularity').on('change', function() {
    var sorting_location = $(this).val();
    window.location.href = sorting_location;
});
/*------------------------------------
Sorting product by category for mobile
-------------------------------------- */
$('#popularity_mobile').on('change', function() {
    var sorting_location = $(this).val();
    window.location.href = sorting_location;
});
/*------------------------------------
Sort by rating
-------------------------------------- */
$('.check_value').on('click', function() {
    var rating_location = $(this).val();
    window.location.href = rating_location;
});
/*------------------------------------
Brand
-------------------------------------- */
$('body').on('click', '.brand_class', function() {
    var brand_location = $(this).val();
    window.location.href = brand_location;
});


$('.star_part a').on('click', function() {
    $('.star_part a').removeClass("active");
    $(this).addClass("active");
});


//Add review
$('body').on('click', '.review', function(e) {
    e.preventDefault();

    var product_id = $("#product_id").val();
    var review_msg = $('#review_msg').val();
    var customer_id = $('#customer_id').val();

    var rate = $('#input-1').val();
    //Review msg check
    if (review_msg == 0) {
        Swal({
            type: 'warning',
            title: display('write_your_comment')
        });
        return false;
    }

    //Customer id check
    if (customer_id == 0) {
        Swal({
            type: 'warning',
            title: display('please_login_first')
        });
        return false;
    }

    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/Home/add_review",
        data: {
            "csrf_test_name": CSRF_TOKEN,
            "product_id": product_id,
            "customer_id": customer_id,
            "review_msg": review_msg,
            "rate": rate
        },
        success: function(data) {
            if (data == '1') {
                $('#review_msg').val('');
                Swal({
                    type: 'success',
                    title: display('your_review_added')
                });
                location.reload();
            } else if (data == '2') {
                $('#review_msg').val('');
                Swal({
                    type: 'warning',
                    title: display('already_reviewed')
                });
                location.reload();
            } else if (data == '3') {
                $('#review_msg').val('');
                Swal({
                    type: 'warning',
                    title: display('please_login_first')
                });
                location.reload();
            }
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            })
        }
    });
});


//Add wishlist
$('body').on('click', '.wishlist', function(e) {
    e.preventDefault();
    var product_id = $(this).attr('name');
    var customer_id = $("#customer_id").val();
    if (customer_id === 0) {
        Swal({
            type: 'warning',
            title: display('please_login_first')
        });
        return false;
    }
    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/Home/add_wishlist",
        data: {
            "csrf_test_name": CSRF_TOKEN,
            "product_id": product_id,
            "customer_id": customer_id
        },
        success: function(data) {
            if (data == 1) {
                Swal({
                    type: 'success',
                    title: display('product_added_to_wishlist')
                });

            } else if (data == 2) {
                Swal({
                    type: 'warning',
                    title: display('product_already_exists_in_wishlist')
                });
            } else if (data == 3) {
                Swal({
                    type: 'warning',
                    title: display('please_login_first')
                });
            }
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            });
        }
    });
});
// remove wishlist
$('body').on('click', '.remove_wishlist', function(e) {
    e.preventDefault();
    var product_id = $(this).attr('name');
    var customer_id = $('#customer_id').val();
    $.ajax({
        type: "post",
        async: true,
        url: base_url + 'web/Home/remove_wishlist',
        data: {
            csrf_test_name: CSRF_TOKEN,
            product_id: product_id,
            customer_id: customer_id
        },
        success: function(data) {
            if (data == '1') {
                Swal({
                    type: 'success',
                    title: display('product_remove_from_wishlist')
                })
            } else if (data == '2') {
                Swal({
                    type: 'warning',
                    title: display('product_not_remove_from_wishlist')
                })
            }
        },
        error: function() {
            Swal({
                type: 'warning',
                title: display('request_failed')
            })
        }
    });
});

/*------------------------------------
BRAND INFO SEARCH
-------------------------------------- */
//Brand Search
$('body').on('keyup', '.brand_search', function() {
    var search_key = $(this).val();

    var category_id = $("#category_id").val();
    var query_string = $("#query_string").val();

    if (query_string) {
        query_string = '?' + query_string;
    } else {
        query_string = '';
    }

    var brand_url_ids = $("#brand_url_ids").val();

    $.ajax({
        type: "post",
        async: true,
        url: base_url + "web/Category/brand_search",
        data: {
            "csrf_test_name": CSRF_TOKEN,
            "search_key": search_key,
            "category_id": category_id,
            "query_string": query_string,
            "brand_url_ids": brand_url_ids
        },
        success: function(data) {
            $('.brand-cat-scroll').html(data);
        },
        error: function(e) {
            swal(display('request_failed'), "", "warning");

        }
    });
});


var stok = $('#stok').val();
if (stok === "none") {
    Swal({
        type: 'warning',
        title: display('please_set_default_store')
    })
}


function validateEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test($email);
}


if (uri_segment === "contact_us") {
    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', init);

    function init() {
        var mapOptions = {
            // How zoomed in you want the map to start at (always required)
            zoom: 14,
            scrollwheel: false,
            // The latitude and longitude to center the map (always required)
            center: new google.maps.LatLng(map_latitude, map_langitude), // Dhaka
        };

        // image from external URL

        var myIcon = base_url + "assets/website/image/marker.png";

        //preparing the image so it can be used as a marker
        var catIcon = {
            url: myIcon,
        };
        var mapElement = document.getElementById('map');

        // Create the Google Map using our element and options defined above
        var map = new google.maps.Map(mapElement, mapOptions);

        // Let's also add a marker while we're at it
        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(map_latitude, map_langitude),
            map: map,
            icon: catIcon,
            title: company_name,
            animation: google.maps.Animation.DROP,
        });
    }
}