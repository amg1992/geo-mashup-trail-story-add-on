<?php
/**
 * Includes all public functions and classes
 * 
 * @package Geo Mashup Trail Story Add-On
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

include_once('trail-story-frontend-form.php');
include_once('geo-mashup-custom.php');

add_action( 'init', 'register_admin_trail_story_scripts' );

function trail_story_enqueue_front_end_scripts(){

    wp_register_script( 'public_trail_story_custom_marker_js', plugins_url('geo-mashup-trail-story-add-on/global/custom-markers.js'), array('jquery'));
    wp_enqueue_script( 'public_trail_story_custom_marker_js' );
    
    //wp_register_style( 'admin_trail_story_css', plugins_url('geo-mashup-trail-story-add-on/inc/admin-trail-story.css'));
    //wp_enqueue_style( 'admin_trail_story_css' );
    //
}

function trail_story_locations_json_filter( $json_properties, $queried_object ) {

    $post_id = $queried_object->object_id;

    $post_type = get_post_type( $post_id );
/*
    if ( $post_type == 'trail-story' ) {

        $json_properties['my_complete'] = 1;

    } else if ( $post_type == 'trail-condition' ) {

        $json_properties['my_complete'] = 2;

    } else if ( $post_type == 'itinerary' ) {

        $json_properties['my_complete'] = 3;

    } else {

        $json_properties[''];

    }

   return $json_properties;*/

    switch ( $post_type ) {

        case 'trail-story':
            $json_properties['my_complete'] = 1;
            return $json_properties;
            break;

        case 'trail-condition':
            $json_properties['my_complete'] = 2;
            return $json_properties;
            break;

        case 'itinerary':
            $json_properties['my_complete'] = 3;
            return $json_properties;
            break;

        default:
            $json_properties[''];
            return $json_properties;

    }

}

add_filter( 'geo_mashup_locations_json_object','trail_story_locations_json_filter', 10, 2 );