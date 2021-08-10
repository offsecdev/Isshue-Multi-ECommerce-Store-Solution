$(document).ready(function () {
	"use strict";
	
    $('.embed_code_ad').css({'display': 'none'});

    $('#ad_type').on('change', function () {
        var ad_style = $('#ad_style option:selected').val();
        var ad_type = $('#ad_type option:selected').val();

        if (ad_type == 1 && ad_style == 1) {
            $('.img_ad1').css({'display': 'none'});
            $('.img_ad2').css({'display': 'none'});
            $('.img_ad3').css({'display': 'none'});
            $('.embed_code_ad').css({'display': 'block'});
        } else if (ad_type == 1 && ad_style == 2) {
            $('.img_ad1').css({'display': 'none'});
            $('.img_ad2').css({'display': 'none'});
            $('.img_ad3').css({'display': 'none'});
            $('.embed_code_ad').css({'display': 'block'});
            $('.embed_code_ad2').css({'display': 'block'});
        } else if (ad_type == 1 && ad_style == 3) {
            $('.img_ad1').css({'display': 'none'});
            $('.img_ad2').css({'display': 'none'});
            $('.img_ad3').css({'display': 'none'});
            $('.embed_code_ad').css({'display': 'block'});
            $('.embed_code_ad2').css({'display': 'block'});
            $('.embed_code_ad3').css({'display': 'block'});
        } else if (ad_type == 2 && ad_style == 1) {
            $('.img_ad1').css({'display': 'block'});
            $('.embed_code_ad').css({'display': 'none'});
            $('.embed_code_ad2').css({'display': 'none'});
            $('.embed_code_ad3').css({'display': 'none'});
        } else if (ad_type == 2 && ad_style == 2) {
            $('.img_ad1').css({'display': 'block'});
            $('.img_ad2').css({'display': 'block'});
            $('.embed_code_ad').css({'display': 'none'});
            $('.embed_code_ad2').css({'display': 'none'});
            $('.embed_code_ad3').css({'display': 'none'});
        } else if (ad_type == 2 && ad_style == 3) {
            $('.img_ad1').css({'display': 'block'});
            $('.img_ad2').css({'display': 'block'});
            $('.img_ad3').css({'display': 'block'});
            $('.embed_code_ad').css({'display': 'none'});
            $('.embed_code_ad2').css({'display': 'none'});
            $('.embed_code_ad3').css({'display': 'none'});
        } else {
            $('.img_ad').css({'display': 'none'});
            $('.embed_code_ad').css({'display': 'none'});
        }
    });

});
