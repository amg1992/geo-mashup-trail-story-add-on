<?php
//Hey there guy.
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

add_shortcode( 'trail_story', 'trail_story_shortcode' );

function trail_story_shortcode( $attributes ) {
    $attr = shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $attributes );

    return "Trail Story shortcode";
}

add_shortcode( 'frontend_trail_story_map', 'frontend_user_map_shortcode' );

function frontend_user_map_shortcode( $attributes ) {
    $attr = shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $attributes );

    return GeoMashupUserUIManager::get_instance()->print_form();
}


