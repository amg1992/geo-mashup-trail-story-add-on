<?php
//Hey there guy.

function trail_story_shortcode( $attributes ) {
    $attr = shortcode_atts( array(
        'foo' => 'something',
        'bar' => 'something else',
    ), $attributes );

    return "Trail Story shortcode";
}

add_shortcode( 'trail_story', 'trail_story_shortcode' );
