// When the window has finished loading create our google map below
google.maps.event.addDomListener(window, 'load', init);

function init() {
    var mapOptions = {
        // How zoomed in you want the map to start at (always required)
        zoom: 14, 
        scrollwheel: false,
        // The latitude and longitude to center the map (always required)
        center: new google.maps.LatLng(23.756107, 90.387196), // Dhaka
    };

    // image from external URL 

    var myIcon = 'image/marker.png';

    //preparing the image so it can be used as a marker
    var catIcon = {
        url: myIcon,
    };
    var mapElement = document.getElementById('map');

    // Create the Google Map using our element and options defined above
    var map = new google.maps.Map(mapElement, mapOptions);

    // Let's also add a marker while we're at it
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(23.756107, 90.387196), 
        map: map,
        icon: catIcon,
        title: 'BDTask',
        animation: google.maps.Animation.DROP,
    });
}