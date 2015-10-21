<?php
/**
 * Includes all public functions and classes
 * 
 * @package Geo Mashup Trail Story Add-On
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

include_once('trail-story-frontend-form.php');
//include_once('geo-mashup-custom.php');

add_action( 'init', 'register_admin_trail_story_scripts' );

function trail_story_enqueue_front_end_scripts(){

    // wp_register_script( 'public_trail_story_custom_marker_js', plugins_url('geo-mashup-trail-story-add-on/global/custom-markers.js'), array('jquery'));
    //wp_enqueue_script( 'public_trail_story_custom_marker_js' );
    
    //wp_register_style( 'admin_trail_story_css', plugins_url('geo-mashup-trail-story-add-on/inc/admin-trail-story.css'));
    //wp_enqueue_style( 'admin_trail_story_css' );
    //
}