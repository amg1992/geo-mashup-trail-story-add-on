    GeoMashup.addAction( 'objectIcon', function( properties, object ) {

    // Use a special icon in case the custom 'complete' var is set to 1
    if ( object.link_to_image_icon != null  ) {

        //object.icon.image = properties.template_url_path + '/member-icons/conversation-map-icon.png';
        object.icon.image = object.link_to_image_icon;
        object.icon.iconSize = [ 32, 37 ];

    } else {

        object.icon.image = properties.template_url_path + '/map-icons/low.png';
        object.icon.iconSize = [ 35, 47 ];

    }
});

/* GeoMashup.addAction( 'loadedMap', function( properties, map ) {

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

//Add support for Google Earth plug-in

//mashup.map.addMapType(G_SATELLITE_3D_MAP);

//mashup.map.addControl(new GHierarchicalMapTypeControl());

//Street View for MH

//if (GeoMashup.opts.load_svMH && confirm('Take a virtual street tour of Morningside Heights (Google Street View requires the Flash plugin)')) {

    //var streetView = new GLatLng(40.697488,-73.979681);

    //panoramaOptions = { latlng:streetView };

    //var svMH = new GStreetviewPanorama(document.getElementById("geoMashup"), panoramaOptions);

//}