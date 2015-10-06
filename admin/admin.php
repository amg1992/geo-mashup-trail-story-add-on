<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );
//Hey there guy.
//include_once('woo-settings-tab.php');
include_once('class-trail-story-settings.php');


add_action( 'init', 'register_admin_trail_story_scripts' );

function register_admin_trail_story_scripts() {
	wp_register_script( 'admin_trail_story_js', plugins_url('geo-mashup-trail-story-add-on/inc/admin-trail-story.js'), array('jquery'));
	wp_register_style( 'admin_trail_story_css', plugins_url('geo-mashup-trail-story-add-on/inc/admin-trail-story.css'));
	wp_enqueue_script( 'admin_trail_story_js' );
	wp_enqueue_style( 'admin_trail_story_css' );
}