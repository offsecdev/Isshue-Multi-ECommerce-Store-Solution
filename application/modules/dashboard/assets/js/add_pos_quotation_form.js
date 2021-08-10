"use strict";
var csrf_test_name = $("#CSRF_TOKEN").val();

function printDiv(divName) {

    var order_tbl = 0;
    $("#order-table tbody tr").each(function(i) {
        order_tbl = order_tbl + 1;
    });

    var bill_tbl = 0;
    $("#bill-table tbody tr").each(function(i) {
        bill_tbl = bill_tbl + 1;
    });

    if (order_tbl < 1) {
        alert('Please select product !');
    } else if (bill_tbl < 1) {
        alert('Please select product !');
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
$(".payment_button").on('click', function() {
    $(".payment_method").toggle();

    //Select Option
    $("select.form-control:not(.dont-select-me)").select2({
        placeholder: "Select option",
        allowClear: true
    });
});


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

    calculateSum();
    invoice_paidamount();

    $('#myModal').modal('hide');
});

//Onload filed select
window.onload = function() {
    var text_input = document.getElementById('add_item');
    text_input.focus();
    text_input.select();
}

//POS Invoice js
$('#add_item').on('keydown', function(e) {
    if (e.keyCode == 13) {
        var product_id = $(this).val();

        if (product_id) {

            $.ajax({
                type: "post",
                async: false,
                url: base_url + 'dashboard/Cinvoice/insert_pos_invoice',
                data: {
                    csrf_test_name: csrf_test_name,
                    product_id: product_id
                },
                success: function(data) {
                    if (data == false) {
                        alert('This Product Not Found !');
                        document.getElementById('add_item').value = '';
                        document.getElementById('add_item').focus();
                    } else {
                        document.getElementById('add_item').value = '';
                        document.getElementById('add_item').focus();
                        $('#addinvoice tbody').append(data);
                        calculateSum();
                        invoice_paidamount();
                    }
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
});

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
                alert('Product Not Found !');
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

                var pos_head1 = '<span class="text-center"><h3>ERP Solution</h3><h4>';
                var pos_head2 = '</h4><p class="text-left">C: ' + $('#select2-customer_name-container').text() + '<br>U: ' + user_name + '<br>T: ' + dateTime + '</p></span>';

                $("#order_span").prepend(styles + pos_head1 + 'Order' + pos_head2);

                $("#bill_span").prepend(styles + pos_head1 + 'Bill' + pos_head2);


                var addSerialNumber = function() {
                    var i = 1
                    $('#order-table tbody tr').each(function(index) {
                        $(this).find('td:nth-child(1)').html('#' + (index + 1));
                    });
                    $('#bill-table tbody tr').each(function(index) {
                        $(this).find('td:nth-child(1)').html('#' + (index + 1));
                    });
                };
                addSerialNumber();

                calculateSum();
                invoice_paidamount();
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