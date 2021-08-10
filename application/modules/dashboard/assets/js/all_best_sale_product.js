"use strict";
var csrf_test_name=  $("#CSRF_TOKEN").val();

//Product purchase or list
// function find_product() {
//     var product_name = $('#product_name').val();
//     $.ajax({
//         type: "POST",
//         url: base_url+'dashboard/Admin_dashboard/find_products',
//         data: {
//                 csrf_test_name:csrf_test_name,
//                 product_name:product_name,
//             },
        
//         success: function(data)
//         {
//             console.log(data);
//         } 
//     });
       
// }

function find_product(sl) {

        var product_name = $('#product_name_'+sl).val();

        // Auto complete ajax
        var options = {
                minLength: 0,
                source: function( request, response ) {
                $.ajax( {
                    url: base_url+'dashboard/Admin_dashboard/find_products',
                    method: 'post',
                    dataType: "json",
                    data: {
                        csrf_test_name:csrf_test_name,
                        product_name:product_name,
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            
            select: function( event, ui ) {
                event.preventDefault();
                $("#product_id").val(ui.item.value);
                $("#product_name_1").val(ui.item.label);
           }
        }
        $('body').on('keydown.autocomplete', '.product_name', function() {
           $(this).autocomplete(options);
        });
    }