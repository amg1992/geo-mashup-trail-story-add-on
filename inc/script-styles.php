<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

/**
* Script styles to run jQuery on pages
*/
add_action( 'wp_enqueue_scripts', 'trail_story_setup_scripts' );

function trail_story_setup_scripts() {
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-ui-core' );
}

/**
* Enqueue scripts
*/
//add_action('wp_footer','trail_story_scripts',5);

function trail_story_scripts() { ?>

<?php $var = get_option('trail_story_option'); ?>

	<script type="text/javascript">

		jQuery(document).ready(function($){
			
	  	});

	</script>

<?php }

/**
* Enqueue styles
*/
add_action('wp_footer','trail_story_styles',10);

function trail_story_styles() { ?>

<?php $var = get_option('trail_story_option'); ?>


	<style type="text/css">


	</style>

<?php }