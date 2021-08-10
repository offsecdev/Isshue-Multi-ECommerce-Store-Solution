
$(document).ready(function() {
    "use strict";
    $('#ad_type').on('change', function() {
        var ad_type = $('#ad_type option:selected').val();
        if (ad_type == 1) {
            $('.img_ad').css({'display': 'none'});
            $('.embed_code_ad').css({'display': 'block'});
        }
        else if (ad_type == 2) {
            $('.img_ad').css({'display': 'block'});
            $('.embed_code_ad').css({'display': 'none'});
        }
        else {
            $('.img_ad').css({'display': 'none'});
            $('.embed_code_ad').css({'display': 'none'});
        }
    });
});
