<?php
/**
* Shortcode file that has all of plugins shortcodes
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );


/**
* Shortcode for showing trail story
*/
add_shortcode( 'trail_story', 'trail_story_shortcode' );

function trail_story_shortcode( $attributes ) {
    $attr = shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $attributes );

    return "Trail Story shortcode";
}

/**
* Shortcode for display frontend user trail story input
*/
add_shortcode( 'frontend_trail_story_map', 'frontend_user_map_shortcode' );

function frontend_user_map_shortcode( $attributes ) {
    $attr = shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $attributes );

    return GeoMashupUserUIManager::get_instance()->print_form();
}


