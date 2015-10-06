<?php
//Hey there guy.
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

function trail_story_shortcode( $attributes ) {
    $attr = shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $attributes );

    return "Trail Story shortcode";
}

add_shortcode( 'trail_story', 'trail_story_shortcode' );
