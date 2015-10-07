<?php // Get out!
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

//if uninstall not called from WordPress exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
    exit();


/*
* Getting options groups
*/
$option_name = 'trail_story_option';
$setting_name = 'trail_story_settings';

/*
* Delete options
*/
delete_option( $option_name );
delete_option( $setting_name );

/*
* For site options in multisite
*/
delete_site_option( $option_name );  
delete_site_option( $setting_name );  

//drop a custom db table
//global $wpdb;
//$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}mytable" );

//note in multisite looping through blogs to delete options on each blog does not scale. You'll just have to leave them.