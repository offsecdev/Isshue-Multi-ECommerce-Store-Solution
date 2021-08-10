"use strict";
// When the window has finished loading create our google map below
google.maps.event.addDomListener(window, 'load', init);

function init() {
    var company_name = $('#company_name').val();
    var map_latitude = $('#map_latitude').val();
    var map_langitude = $('#map_langitude').val();

    var mapOptions = {
        // How zoomed in you want the map to start at (always required)
        zoom: 14,
        scrollwheel: false,
        // The latitude and longitude to center the map (always required)
        center: new google.maps.LatLng(map_latitude, map_langitude), // Dhaka
    };

    // image from external URL

    var myIcon = base_url+'assets/website/image/marker.png';

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
