$(document).ready(function() {
    "use strict";
    var csrf_test_name = $("#CSRF_TOKEN").val();
    $('#onsale').on('change', function() {
        var onsale = $('#onsale option:selected').val();
        if (onsale == 1) {
            $('.onsale_price').css({
                'display': 'block'
            });
           
            $("#variant_prices").prop('checked',false);
             $('#set_variant_price').css({
                'display': 'none'
            });
            $('#variant_price_area').css({
                'display': 'none'
            });
        } else {
            $('.onsale_price').css({
                'display': 'none'
            });
            $('#variant_price_area').css({
                'display': 'block'
            });
        }
    });

    $('#variant_prices').on('click', function() {

        if( $(this).prop('checked') == true){
            $('#set_variant_price').show('slow');
        }else{
            $('#set_variant_price').hide('slow');
        }
    });


    //Root wizard progress bar
    $('#rootwizard').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'onNext': validateTab,
        'onTabClick': validateTab
    });
    //Form wizard
    var $validator = $("#commentForm").validate();


    //Validate filed
    function validateTab(tab, navigation, index, nextIndex) {
        if (nextIndex <= index) {
            return;
        }
        var commentForm = $("#commentForm")
        var $valid = commentForm.valid();
        if ($valid) {
            var $total = navigation.find('li').length;
            var $current = index + 1;
            var $percent = ($current / $total) * 100;
            $('#rootwizard .progress-bar').css({
                width: $percent + '%'
            });
        } else {
            $validator.focusInvalid();
            return false;
        }

        if (nextIndex > index + 1) {
            for (var i = index + 1; i < nextIndex - index + 1; i++) {
                $('#rootwizard').bootstrapWizard('show', i);
                $valid = commentForm.valid();
                if (!$valid) {
                    $validator.focusInvalid();
                    return false;
                }
            }
            return false;
        }
    }


    // Variant Size
    $('#variant').on('change', function() {

        var variants = $(this).val();
        $.ajax({
            url: base_url + 'dashboard/Cproduct/get_default_variant',
            type: "post",
            data: {
                csrf_test_name: csrf_test_name,
                variants: variants
            },
            success: function(data) {
                $('#default_variant').html(data);
                var fulldata = '<option value=""></option>' + data;
                $('#size_var').html(fulldata);
            }

        })
    });

    // Variant Color
    $('#variant_colors').on('change', function() {

        var variants = $(this).val();
        $.ajax({
            url: base_url + 'dashboard/Cproduct/get_default_variant',
            type: "post",
            data: {
                csrf_test_name: csrf_test_name,
                variants: variants
            },
            success: function(data) {
              var fulldata = '<option value=""></option>' + data;
              $('#color_var').html(fulldata);
            }

        })
    });

});


//insert multiple image row
var imageRowCounter = 1;
 var csrf_test_name = $("#CSRF_TOKEN").val();

function addImageRow(air) {
    "use strict";
    air = +air + 1;
    var imageRow = '';
    imageRow = '<div id="image_row_' + air + '"><div class="row"><div class="col-md-6"> <div class="form-group row"><label for="imageUpload" class="col-sm-4 col-form-label">' + display("image") + '<i class="text-danger">*</i></label><div class="col-sm-8"><input required class="form-control" name="imageUpload[]" type="file" id="imageUpload" data-toggle="tooltip" data-placement="top" title="" aria-required="true"> </div></div></div> <input type="button" value="+" onClick="addImageRow(' + air + ');" class="btn btn-info" id="image-add"> <input type="button" value="-" onclick="deleteImageRow(this);"  class="btn btn-danger"  id="image-remove"></div></div>';
    $('#image_row').append(imageRow);
    imageRowCounter++;
}

function deleteImageRow(dir) {
    "use strict";
    var imageId = $(dir).attr('data-image_id');
    if (imageId) {
        swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: base_url + 'dashboard/Cproduct/delete_gallery_image',
                        type: "post",
                        data: {
                            csrf_test_name: csrf_test_name,
                            imageId: imageId
                        },
                        success: function(data) {
                            $("#image_row").load(location.href + " #image_row>*", "");
                        }
                    })
                } else {
                    swal("Your imaginary file is safe!");
                }
            });
    }
    var imageRowDiv = $(dir).prev().closest('div').parent().attr('id');
    if (imageRowDiv != 'image_row_0') {
        $('#' + imageRowDiv).remove();
    }
}

// Variant wise price set
$('#variant-row-add').on('click', function(e) {
    e.preventDefault();
    var key_val = $(this).attr('data-key');
    var size_variant_id = $('#size_var').val();
    var size_variant_txt = $('#size_var option:selected').text();
    var color_variant_id = $('#color_var').val();
    var color_variant_txt = $('#color_var option:selected').text();
    var var_price = $('#var_price').val();

    if ((size_variant_id != '') && (var_price != '')) {

        var variant_row = '<tr id="row_' + key_val + '"><td>' + size_variant_txt + ' <input type="hidden" name="size_variant[' + key_val + ']" value="' + size_variant_id + '"></td><td>' + color_variant_txt + ' <input type="hidden" name="color_variant[' + key_val + ']" value="' + color_variant_id + '"></td><td>' + var_price + ' <input type="hidden" name="variant_price_amt[' + key_val + ']" value="' + var_price + '"></td><td><input type="button" value="-" onclick="deleteVariantRow(' + key_val + ');" class="btn btn-danger" id="variant-row-remove"></td></tr>';

        $('#variant_area').append(variant_row);
        $('#variant-row-add').attr('data-key', parseInt(key_val) + 1);
        $('#size_var').val('').trigger('change');
        $('#color_var').val('').trigger('change');
        $('#var_price').val('');
    } else {
        Swal({
            type: 'warning',
            title: 'Please select size and price!'
        });
    }
});

function deleteVariantRow(key_val) {
    "use strict";
    $('#row_' + key_val).remove();
}