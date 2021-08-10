$(document).ready(function () {
"use strict";
var csrf_test_name=  $("#CSRF_TOKEN").val();
/*------------------------------------
Price range slide
-------------------------------------- */
var min_value = $('#min_value').val();
var max_value = $('#max_value').val();
var from_price = $('#from_price').val();
var to_price = $('#to_price').val();
var default_currency_icon = $('#default_currency_icon').val();

$(".price-range").ionRangeSlider({
    type: "double",
    grid: true,
    min: min_value,
    max: max_value,
    from: from_price,
    to: to_price,
    prefix: default_currency_icon,
    onChange: function (data) {

        //field "search";
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
$('body').on('click', '.size1', function () {
    var size_location = $(this).val();
    window.location.href = size_location;
});
/*------------------------------------
Sorting product by category
-------------------------------------- */
$('#popularity').on('change', function () {
    var sorting_location = $(this).val();
    window.location.href = sorting_location;
});
/*------------------------------------
Sorting product by category for mobile
-------------------------------------- */
$('#popularity_mobile').on('change', function () {
    var sorting_location = $(this).val();
    window.location.href = sorting_location;
});
/*------------------------------------
Sort by rating
-------------------------------------- */
$('.check_value').on('click', function () {
    var rating_location = $(this).val();
    window.location.href = rating_location;
});
/*------------------------------------
Brand
-------------------------------------- */
$('body').on('click', '.brand_class', function () {
    var brand_location = $(this).val();
    window.location.href = brand_location;
});
});


