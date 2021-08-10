"use strict";
var csrf_test_name = $("#CSRF_TOKEN").val();
var company_name = $("#company_name").val();
//check variant selected or not
$(document).on("click", ":submit", function(e) {

    var variant_value = $('.variant_id').val();
    if (variant_value === 'Select Variant') {
        alert(display('select_variant'));
        return false;
    } else {
        return true;
    }

});
// ============================================

$('#myModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var modal = $(this);
    var rowID = button.parent().parent().attr('id');
    var product_name = $("#product_name_" + rowID).text();
    var rate = $("#price_item_" + rowID).val();
    var quantity = $("#total_qntt_" + rowID).val();
    var available_quantity = $(".available_quantity_" + rowID).val();
    var unit = $(".unit_" + rowID).val();
    var discount = $("#discount_" + rowID).val();

    modal.find('.modal-title').text(product_name);
    modal.find('.modal-body input[name=rowID]').val(rowID);
    modal.find('.modal-body input[name=product_name]').val(product_name);
    modal.find('.modal-body input[name=rate]').val(rate);
    modal.find('.price').text(rate);
    modal.find('.modal-body input[name=quantity]').val(quantity);
    modal.find('.modal-body input[name=available_quantity]').val(available_quantity);
    modal.find('.modal-body input[name=unit]').val(unit);
    modal.find('.modal-body input[name=discount]').val(discount);
});

//Update POS cart
$('#updateCart').on('submit', function(e) {
    e.preventDefault();
    var rate = $(this).find('input[name=rate]').val();
    var quantity = $(this).find('input[name=quantity]').val();
    var discount = $(this).find('input[name=discount]').val();
    var rowID = $(this).find('input[name=rowID]').val();

    $("#price_item_" + rowID).val(rate);
    $("#total_qntt_" + rowID).val(quantity);
    $("#total_price_" + rowID).val(quantity * rate);
    $("#discount_" + rowID).val(discount);
    $("#total_discount_" + rowID).val(discount);
    $("#all_discount_" + rowID).val(discount * quantity);

    quantity_calculate(rowID);

    $('#myModal').modal('hide');
});

//Onload filed select
window.onload = function() {
    var text_input = document.getElementById('add_item');
    text_input.focus();
    text_input.select();
};
var barcodeScannerTimer;
var barcodeString = '';

//POS Invoice js
$('#add_item').on('keypress', function(e) {
    barcodeString = barcodeString + String.fromCharCode(e.charCode);

    clearTimeout(barcodeScannerTimer);
    barcodeScannerTimer = setTimeout(function() {
        processBarcode();
    }, 300);

});

function processBarcode() {

    if (!isNaN(barcodeString) && barcodeString != '') {
        var product_id = barcodeString;

        var today = new Date();
        var date = (today.getMonth() + 1) + '-' + today.getDate() + '-' + today.getFullYear();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date + ' ' + time;
        var user_name = $('#user_name').val();

        if (product_id) {

            $.ajax({
                type: "post",
                dataType: "json",
                async: false,
                url: base_url + 'dashboard/Cinvoice/insert_pos_invoice',
                data: {
                    csrf_test_name: csrf_test_name,
                    product_id: product_id
                },
                success: function(data) {
                    if (data.item == 0) {
                        alert('Product not available in stock !');
                        document.getElementById('add_item').value = '';
                        document.getElementById('add_item').focus();
                    } else {
                        document.getElementById('add_item').value = '';
                        document.getElementById('add_item').focus();
                        $('#addinvoice tbody').append(data.item);
                        $('#order-table tbody').append(data.order);
                        $('#bill-table tbody').append(data.bill);

                        $("#order_span").empty();
                        $("#bill_span").empty();
                        var styles = '<style>table, th, td { border-collapse:collapse; border-bottom: 1px solid #CCC; } .no-border { border: 0; } .bold { font-weight: bold; }</style>';

                        var pos_head1 = '<span class="text-center"><h3>' + company_name + '</h3><h4>';
                        var pos_head2 = '</h4><p class="text-left">C: ' + $('#select2-customer_name-container').text() + '<br>U: ' + user_name + '<br>T: ' + dateTime + '</p></span>';

                        $("#order_span").prepend(styles + pos_head1 + 'Order' + pos_head2);

                        $("#bill_span").prepend(styles + pos_head1 + 'Bill' + pos_head2);


                        var addSerialNumber = function() {
                            var i = 1;
                            $('#order-table tbody tr').each(function(index) {
                                $(this).find('td:nth-child(1)').html('#' + (index + 1));
                            });
                            $('#bill-table tbody tr').each(function(index) {
                                $(this).find('td:nth-child(1)').html('#' + (index + 1));
                            });
                        };
                        addSerialNumber();

                        quantity_calculate(data.product_id);
                    }

                    //Total items count
                    $('#item-number').html('0');
                    $(".itemNumber>tr").each(function(i) {
                        $('#item-number').html(i + 1);
                        $('.item_bill').html(i + 1);
                    });

                    $('#item-number').html('0');
                    $(".itemNumber>tr").each(function(i) {
                        $('#item-number').html(i + 1);
                    });

                },
                error: function() {
                    alert('Request Failed, Please try again!');
                }
            });
        }
    }
    barcodeString = ''; // reset
};

//Product search js
$('body').on('keyup', '#product_name', function() {
    var product_name = $(this).val();
    var category_id = $('#category_id').val();
    $.ajax({
        type: "post",
        async: false,
        url: base_url + 'dashboard/Cinvoice/search_product',
        data: {
            csrf_test_name: csrf_test_name,
            product_name: product_name,
            category_id: category_id
        },
        success: function(data) {
            if (data == '420') {
                $("#product_search").html('Product not found !');
            } else {
                $("#product_search").html(data);
            }
        },
        error: function() {
            alert('Request Failed, Please try again!');
        }
    });
});

//Product search js
$('body').on('change', '#category_id', function() {
    var product_name = $('#product_name').val();
    var category_id = $('#category_id').val();
    $.ajax({
        type: "post",
        async: false,
        url: base_url + 'dashboard/Cinvoice/search_product',
        data: {
            csrf_test_name: csrf_test_name,
            product_name: product_name,
            category_id: category_id
        },
        success: function(data) {
            if (data == '420') {
                $("#product_search").html('Product not found !');
            } else {
                $("#product_search").html(data);
            }
        },
        error: function() {
            alert('Request Failed, Please try again!');
        }
    });
});

//Product search button js
$('body').on('click', '#search_button', function() {
    var product_name = $('#product_name').val();
    var category_id = $('#category_id').val();
    $.ajax({
        type: "post",
        async: false,
        url: base_url + 'dashboard/Cinvoice/search_product',
        data: {
            csrf_test_name: csrf_test_name,
            product_name: product_name,
            category_id: category_id
        },
        success: function(data) {
            if (data == '420') {
                $("#product_search").html('Product not found !');
            } else {
                $("#product_search").html(data);
            }
        },
        error: function() {
            alert('Request Failed, Please try again!');
        }
    });
});


//Product search button js
$('body').on('click', '.select_product', function(e) {
    e.preventDefault();

    var today = new Date();
    var date = (today.getMonth() + 1) + '-' + today.getDate() + '-' + today.getFullYear();
    var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    var dateTime = date + ' ' + time;
    var user_name = $('#user_name').val();

    var panel = $(this);
    var product_id = panel.find('.panel-body input[name=select_product_id]').val();

    $.ajax({
        type: "post",
        dataType: "json",
        async: false,
        url: base_url + 'dashboard/Cinvoice/insert_pos_invoice',
        data: {
            csrf_test_name: csrf_test_name,
            product_id: product_id
        },
        success: function(data) {

            if (data.item == 0) {
                alert('Product not available in stock !');
                document.getElementById('add_item').value = '';
                document.getElementById('add_item').focus();
            } else {
                document.getElementById('add_item').value = '';
                document.getElementById('add_item').focus();
                $('#addinvoice tbody').append(data.item);
                $('#order-table tbody').append(data.order);
                $('#bill-table tbody').append(data.bill);

                $("#order_span").empty();
                $("#bill_span").empty();
                var styles = '<style>table, th, td { border-collapse:collapse; border-bottom: 1px solid #CCC; } .no-border { border: 0; } .bold { font-weight: bold; }</style>';

                var pos_head1 = '<span class="text-center"><h3>' + company_name + '</h3><h4>';
                var pos_head2 = '</h4><p class="text-left">C: ' + $('#select2-customer_name-container').text() + '<br>U: ' + user_name + '<br>T: ' + dateTime + '</p></span>';

                $("#order_span").prepend(styles + pos_head1 + 'Order' + pos_head2);
                $("#bill_span").prepend(styles + pos_head1 + 'Bill' + pos_head2);

                var addSerialNumber = function() {
                    var i = 1;
                    $('#order-table tbody tr').each(function(index) {
                        $(this).find('td:nth-child(1)').html('#' + (index + 1));
                    });
                    $('#bill-table tbody tr').each(function(index) {
                        $(this).find('td:nth-child(1)').html('#' + (index + 1));
                    });
                };
                addSerialNumber();

                quantity_calculate(data.product_id);
            }

            //Total items count
            $('#item-number').html('0');
            $(".itemNumber>tr").each(function(i) {
                $('#item-number').html(i + 1);
                $('.item_bill').html(i + 1);
            });

        },
        error: function() {
            alert('Request Failed, Please try again!');
        }
    });
});


//Select stock by product and variant id
$('body').on('change', '.variant_id', function() {

    var sl = $(this).parent().parent().find(".sl").val();
    var product_id = $('.product_id_' + sl).val();
    var avl_qntt = $('.available_quantity_' + sl).val();
    var store_id = $('#store_id').val();
    var variant_id = $(this).val();
    var variant_color = $("#variant_color_" + sl).val();

    if (store_id == 0) {
        alert('Please select store !');
        return false;
    }
    $.ajax({
        type: "post",
        async: false,
        url: base_url + 'dashboard/Cpurchase/check_admin_2d_variant_info',
        data: {
            csrf_test_name: csrf_test_name,
            product_id: product_id,
            variant_id: variant_id,
            store_id: store_id,
            variant_color: variant_color
        },
        success: function(result) {
            var res = JSON.parse(result);
            if (res[0] == 'yes') {
                $('.available_quantity_' + sl).val(res[1]);
                $('#price_item_' + sl).val(res[2]);
                $('#discount_' + sl).val(res[3]);
                quantity_calculate(sl);
            } else {
                $('.available_quantity_' + sl).val('');
                $("#variant_id_" + sl).val('');
                alert('Product is not available in stock !');
                return false;
            }
        },
        error: function() {
            alert('Request Failed, Please try again!');
        }
    });
});

//Select stock by product and variant id
$('body').on('change', '.variant_color', function() {

    var sl = $(this).parent().parent().find(".sl").val();
    var product_id = $('.product_id_' + sl).val();
    var avl_qntt = $('.available_quantity_' + sl).val();
    var store_id = $('#store_id').val();
    var variant_id = $("#variant_id_" + sl).val();
    var variant_color = $(this).val();

    if (store_id == 0) {
        alert('Please select store !');
        return false;
    }
    $.ajax({
        type: "post",
        async: false,
        url: base_url + 'dashboard/Cpurchase/check_admin_2d_variant_info',
        data: {
            csrf_test_name: csrf_test_name,
            product_id: product_id,
            variant_id: variant_id,
            store_id: store_id,
            variant_color: variant_color
        },
        success: function(result) {
            var res = JSON.parse(result);
            if (res[0] == 'yes') {
                $('.available_quantity_' + sl).val(res[1]);
                $('#price_item_' + sl).val(res[2]);
                $('#discount_' + sl).val(res[3]);
                quantity_calculate(sl);
            } else {
                $('.available_quantity_' + sl).val('');
                $("#variant_color_" + sl).val('');
                alert('Product is not available in stock !');
                return false;
            }
        },
        error: function() {
            alert('Request Failed, Please try again!');
        }
    });
});

var limit = 0;
var total_product = $('#total_product').val();
$(parent.window.document).scroll(function() {

    var per_page = 20;
    limit = limit + per_page;
    if (limit <= total_product) {

        $.ajax({
            type: "post",
            async: false,
            url: base_url + 'dashboard/Cinvoice/get_pos_product',
            data: {
                csrf_test_name: csrf_test_name,
                per_page: per_page,
                limit: limit
            },
            success: function(data) {
                console.log(data);

                $('#product_search').append(data);
            }
        });

    } else {
        return false;
    }

});