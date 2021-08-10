"use strict";
var csrf_test_name=  $("#CSRF_TOKEN").val();
//Bank Information Show
function bank_info_show(payment_type) {
    if (payment_type.value == "1") {
        document.getElementById("bank_info_hide").style.display = "none";
    }
    else {
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
    }
    else {
        document.getElementById("payment_from_1").style.display = "none";
        document.getElementById("payment_from_2").style.display = "block";
        document.getElementById("myRadioButton_2").checked = false;
        document.getElementById("myRadioButton_1").checked = true;
        document.getElementById("SchoolHiddenId").removeAttribute("value");
        $('#customer_name').val('');
    }
}


    // Counts and limit for invoice
    var count = 2;
    var limits = 500;

    //Add Invoice Field
    function addInputField(divName) {

        if (count == limits) {
            alert("You have reached the limit of adding " + count + " inputs");
        }
        else {
            var newdiv = document.createElement('tr');
            var tabin = "product_name_" + count;

            $("select.form-control:not(.dont-select-me)").select2({
                placeholder: "Select option",
                allowClear: true
            });

            var cgst_status = $('#cgst_status').val();
            var sgst_status = $('#sgst_status').val();
            var igst_status = $('#igst_status').val();
            var taxhtmlval = '';

            if (cgst_status == 1) {

            taxhtmlval = '<input type="hidden" id="cgst_' + count + '" class="cgst"/> <input type="hidden" id="total_cgst_' + count + '" class="total_cgst" name="cgst[]" /> <input type="hidden" name="cgst_id[]" id="cgst_id_' + count + '">';
            }if (sgst_status == 1) {

            taxhtmlval = '<input type="hidden" id="sgst_' + count + '" class="sgst"/> <input type="hidden" id="total_sgst_' + count + '" class="total_sgst" name="sgst[]"/><input type="hidden" name="sgst_id[]" id="sgst_id_' + count + '">';

            }if (igst_status == 1) {

            taxhtmlval = '<input type="hidden" id="igst_' + count + '" class="igst"/><input type="hidden" id="total_igst_' + count + '" class="total_igst" name="igst[]"/><input type="hidden" name="igst_id[]" id="igst_id_' + count + '">';
            }


            newdiv.innerHTML = '<tr><td><input type="text" name="product_name" onkeyup="invoice_productList(' + count
                + ');" class="form-control productSelection" placeholder="'+display('product_name')+'" required="" id="product_name_' + count + '" ><input type="hidden" class="autocomplete_hidden_value product_id_' + count + '" name="product_id[]"/><input type="hidden" class="sl" value="' + count + '"><input type="hidden" class="baseUrl" value="'+base_url+'" /></td><td class="text-center"> <div class="variant_id_div"><select name="variant_id[]" id="variant_id_' + count + '" class="form-control variant_id width_100p" required=""><option value=""></option></select></div><div><select name="color_variant[]" id="variant_color_id_'+count+'" class="form-control color_variant width_100p" ><option value=""></option></select></div></td><td><input type="text" name="available_quantity[]"  class="form-control text-right available_quantity_' + count + '" id="avl_qntt_' + count + '" placeholder="0" readonly="1" /></td> <td><input type="text" id="" class="form-control text-right unit_' + count + '" placeholder="None" readonly="" /></td><td><input type="number" onchange="quantity_limit('+count+')" name="product_quantity[]" onkeyup="quantity_calculate(' + count + ');" onchange="quantity_calculate(' + count + ');" id="total_qntt_' + count + '" class="form-control text-right" value="1" min="1" required="" /></td><td><input type="number" name="product_rate[]" onkeyup="quantity_calculate(' + count + ');" onchange="quantity_calculate(' + count + ');" placeholder="0.00" id="price_item_' + count + '" class="price_item' + count + ' form-control text-right" required="" min="0" /></td><td><input type="number" name="discount[]" onkeyup="quantity_calculate(' + count + ');" onchange="quantity_calculate(' + count + ');" id="discount_' + count + '" class="form-control text-right" placeholder="0.00" min="0" /></td><td><input class="total_price form-control text-right" type="text" name="total_price[]" id="total_price_' + count + '" placeholder="0.00" readonly="readonly" /></td>' +

                '<td>' +taxhtmlval +
                '<input type="hidden" id="total_discount_' + count + '" class="" />' +
                '<input type="hidden" id="all_discount_' + count + '" class="total_discount"/><button class="btn btn-danger text-right" type="button" value="'+display('delete')+'" onclick="deleteRow(this)">'+display('delete')+'</button></td></tr>';
            document.getElementById(divName).appendChild(newdiv);
            document.getElementById(tabin).focus();
            count++;

            $("select.form-control:not(.dont-select-me)").select2({
                placeholder: "Select option",
                allowClear: true
            });
        }
    }


    //Select stock by product and variant id
    $('body').on('change', '.variant_id', function () {

        var sl = $(this).parent().parent().parent().find(".sl").val();
        var product_id = $('.product_id_' + sl).val();
        var avl_qntt = $('#avl_qntt_' + sl).val();
        var store_id = $('#store_id').val();
        var variant_id = $(this).val();
        var variant_color   = $('#variant_color_id_'+sl).val();

        if (store_id == 0) {
            alert(display('please_select_store'));
            return false;
        }

        $.ajax({
            type: "post",
            async: false,
            url: base_url+'dashboard/Cpurchase/check_admin_2d_variant_info',
            data: {csrf_test_name:csrf_test_name, product_id: product_id, variant_id: variant_id, store_id: store_id, variant_color:variant_color},
            success: function (result) {

                var res = JSON.parse(result);
                if(res[0]=='yes'){
                    $('#avl_qntt_'+sl).val(res[1]);
                    $('#discount_'+sl).val(res[3]);
                    $('#price_item_'+sl).val(res[2]).change();
                }else{
                   $('#avl_qntt_'+sl).val('');
                    alert(display('product_is_not_available_in_this_store'));
                    return false; 
                }

            },
            error: function () {
                alert('Request Failed, Please check and try again!');
            }
        });
    });

    //Select stock by product and color variant id
    $('body').on('change', '.color_variant', function() {

        var sl         = $(this).parent().parent().parent().find(".sl").val();
        var product_id = $('.product_id_'+sl).val();
        var avl_qntt   = $('#avl_qntt_'+sl).val();
        var store_id   = $('#store_id').val();
        var variant_id   = $('#variant_id_'+sl).val();
        var variant_color = $(this).val();

        if (store_id == 0) {
            alert(display('please_select_store'));
            return false;
        }

        $.ajax({
            type: "post",
            async: false,
            url: base_url+'dashboard/Cpurchase/check_admin_2d_variant_info',
            data: {csrf_test_name:csrf_test_name, product_id: product_id, variant_id:variant_id, store_id:store_id, variant_color:variant_color},
            success: function(result) {

                 var res = JSON.parse(result);
                if(res[0]=='yes'){
                    $('#avl_qntt_'+sl).val(res[1]);
                    $('#discount_'+sl).val(res[3]);
                    $('#price_item_'+sl).val(res[2]).change();
                }else{
                   $('#avl_qntt_'+sl).val('');
                    alert(display('product_is_not_available_in_this_store'));
                    return false; 
                }
            },
            error: function() {
                alert('Request Failed, Please try again!');
            }
        });
    });


    //========================================================================================
    //after select variant check  limit to order limit
    $('#total_qntt_1').on('change', function () {
        var current_quantity = $("#total_qntt_1").val();
        var available_quantity = $("#avl_qntt_1").val();
        if (parseInt(available_quantity) < parseInt(current_quantity)) {
            alert('stock not available');
            $("#total_qntt_1").val(1);
            return false;
        }
    })
