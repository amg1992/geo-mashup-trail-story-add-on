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

