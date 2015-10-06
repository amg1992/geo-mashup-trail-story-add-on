<?php 
/**
 * Plugin Name: Geo Mashup Trail Story Add-On
 * Plugin URI:  http://www.orionweb.net
 * Description: Geo Mashup Trail Story Add-On
 * Author:      Orion Group
 * Author URI:  http://www.orionweb.net
 * Version:     0.0.1
 * Text Domain: geo-mashup-trail-story-add-on
 * Domain Path: /languages/
 * License: GPL2
 * 
 * @package Geo Mashup Assistant
 */
// Exit if accessed directly

defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );
//if ( !defined( 'ABSPATH' ) ) exit;

/**
* Including files in other directories
*/
include_once('admin/admin.php');
include_once('inc/shortcode.php');
include_once('inc/script-styles.php');

/**
* Register and enqueue jQuery files to run on frontend, enqueue on admin_init
*/
add_action( 'init', 'register_trail_story_scripts' );

function register_trail_story_scripts() {
	wp_register_script( 'trailstory_js', plugins_url('inc/trail-story.js', __FILE__), array('jquery'));
	wp_register_style( 'trailstory_css', plugins_url('inc/trail-story.css', __FILE__));
	wp_enqueue_script( 'trailstory_js' );
	wp_enqueue_style( 'trailstory_css' );
}


/**
* Adding Settings link to plugin page
*/
add_filter( 'plugin_action_links', 'trail_story_settings_link', 10, 5 );

function trail_story_settings_link( $actions, $plugin_file )
{
	static $plugin;

	if (!isset($plugin))
		$plugin = plugin_basename(__FILE__);

		if ($plugin == $plugin_file) {

			$settings = array('settings' => '<a href="admin.php?page=wc-settings&tab=products&section=outofstock">' . __('Settings', 'General') . '</a>',
							  'reports' => '<a href="edit.php?post_type=product&page=outofstock-stats">' . __('Reports', 'General') . '</a>');

    			$actions = array_merge($settings, $actions);
		}

		return $actions;
}