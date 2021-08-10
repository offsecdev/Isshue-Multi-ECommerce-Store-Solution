    // When the window has finished loading create our google map below
    google.maps.event.addDomListener(window, 'load', init);

    function init() {
        var mapOptions = {
            // How zoomed in you want the map to start at (always required)
            zoom: 13, 
            scrollwheel: false,
            // The latitude and longitude to center the map (always required)
            center: new google.maps.LatLng(23.756107, 90.387196), // Dhaka
            // This is where you would paste any style found on Snazzy Maps.
            styles: [{"featureType": "administrative", "elementType": "labels.text.fill", "stylers": [{"color": "#444444"}]}, {"featureType": "administrative.locality", "elementType": "labels.text.stroke", "stylers": [{"visibility": "on"}]}, {"featureType": "administrative.locality", "elementType": "labels.icon", "stylers": [{"visibility": "on"}, {"color": "#2a66bf"}]}, {"featureType": "landscape", "elementType": "all", "stylers": [{"color": "#aaa"}]}, {"featureType": "poi", "elementType": "all", "stylers": [{"visibility": "off"}]}, {"featureType": "road", "elementType": "all", "stylers": [{"saturation": -100}, {"lightness": 45}]}, {"featureType": "road.highway", "elementType": "all", "stylers": [{"visibility": "simplified"}]}, {"featureType": "road.arterial", "elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {"featureType": "transit", "elementType": "all", "stylers": [{"visibility": "off"}]}, {"featureType": "water", "elementType": "all", "stylers": [{"color": "#2a66bf"}, {"visibility": "on"}]}]

        };

        // image from external URL 

        var myIcon = './marker.png';
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