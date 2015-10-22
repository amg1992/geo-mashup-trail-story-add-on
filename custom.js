GeoMashup.addAction( 'objectIcon', function( properties, object ) {

    // Use a special icon in case the custom 'complete' var is set to 1
    if ( object.link_to_image_icon != null && typeof object.link_to_image_icon !== 'undefined' ) {

        object.icon.image = object.link_to_image_icon;
        object.icon.iconSize = [ 32, 37 ];

    } else {
        
        object.icon.image = properties.template_url_path + '/map-icons/low.png';
        object.icon.iconSize = [ 35, 47 ];

    }
});

 
/*
** Customizes the look of map
 */
/*GeoMashup.addAction( 'loadedMap', function( properties, map ) {

    var google_map = map.getMap();

    var custom_styles = [{
        featureType: "all",
        elementType: "all",
        stylers: [
            { saturation: -97 }
        ]
    },{
        featureType: "administrative.locality",
        elementType: "all",
        stylers: [
            { visibility: "off" }
        ]
    },{
        featureType: "road.highway",
        elementType: "all",
        stylers: [
            { visibility: "on" },
            { hue: "#E39939" },
            { saturation: 70 },
            { lightness: 30 }
        ]
    },{
        featureType: "transit.station",
        elementType: "all",
        stylers: [
            { visibility: "on" },
            { color: "#f30000" },
        ]
    },{
        featureType:    "poi.park",
        elementType:    "geometry.fill",
        stylers: [ 
            { visibility:"on" },
            { color: "#238300" },
            { saturation:150 },
            { lightness:10 },
        ]
    },{
        featureType:    "water",
        elementType:    "geometry.fill",
        stylers: [ 
            { visibility:"on" },
            { color: "#5794bf" },
            { saturation:70 },
        ]
    },{
        featureType: "poi",
        elementType: "labels",
        stylers: [
            { visibility: "off" }
        ]
    },{
        featureType: "administrative.neighborhood",
        elementType: "all",
        stylers: [
            { visibility: "on" }
        ]
    },{
        featureType: "all",
        elementType: "labels.text",
        stylers: [
            { color: "#555555" },
            { weight: "0.1" },
        ]
    },{       
        featureType: "administrative.neighborhood",
        elementType: "labels.text",
        stylers: [
            { color: "#733e1d"},
            { weight: "0.1" },
        { visibility: "on" }
        ]
    },{       
        featureType: "transit.station",
        elementType: "labels.text",
        stylers: [
            { visibility: "on" },
            { color: "#f30000" },
            { weight:"0.05" },
        ]
    },{
        featureType: "transit.station.bus",
        elementType: "geometry",
        stylers: [
            { visibility: "on" },
            { color: "#f30000" },
            { weight:"0.05" },
        ]
    },{
        featureType: "road.arterial",
        elementType: "all",
        stylers: [
            { saturation: 70 },
            { hue: "#E39939" },
            { lightness: 30 }
        ]
    }];

    var map_type = new google.maps.StyledMapType( custom_styles, { name: 'rsf' } );

    google_map.mapTypes.set( 'yellow', map_type );

    google_map.setMapTypeId( 'yellow' );

}); */