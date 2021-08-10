"use strict";
$(document).ready(function(){
    $('#variant_type').on('change', function(){
        var variant_type = $(this).val();
        if(variant_type == 'color'){
            $('#color_code_area').show();
        }else{
          $('#color_code_area').hide();  
        }
    }); 
});