<?php
/**
 * The Geo Mashup Custom class.
 */
if ( !class_exists( 'GeoMashupCustom' ) ) {
class GeoMashupCustom {
	var $files = array();
	var $found_files;
	var $dir_path;
	var $url_path;
	var $basename;
	var $warnings = '';

	/**
	 * PHP4 Constructor
	 */
	function GeoMashupCustom() {

		// Initialize members
		$this->dir_path = dirname( __FILE__ );
		$this->basename = plugin_basename( __FILE__ );
		$dir_name = substr( $this->basename, 0, strpos( $this->basename, '/' ) );
		$this->url_path = trailingslashit( WP_PLUGIN_URL ) . $dir_name;
		load_plugin_textdomain( 'GeoMashupCustom', 'wp-content/plugins/'.$dir_name, $dir_name );
		
		// Inventory custom files
		if ( $dir_handle = @ opendir( $this->dir_path ) ) {
			$self_file = basename( __FILE__ );
			while ( ( $custom_file = readdir( $dir_handle ) ) !== false ) {
				if ( $self_file != $custom_file && !strpos( $custom_file, '-sample' ) && !is_dir( $custom_file ) ) {
					$this->files[$custom_file] = trailingslashit( $this->url_path ) . $custom_file;
				}
			}
		}

		// Scan Geo Mashup after it has been loaded
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );

		// Output messages
		add_action( 'after_plugin_row_' . $this->basename, array( $this, 'after_plugin_row' ), 10, 2 );
	}

	/**
	 * Once all plugins are loaded, we can examine Geo Mashup.
	 */
	function plugins_loaded() {
		if ( defined( 'GEO_MASHUP_DIR_PATH' ) ) {
			// Check version
			if ( GEO_MASHUP_VERSION <= '1.2.4' ) {
				$this->warnings .= __( 'Custom files can be stored safely in this plugin folder, but will only be used by versions of Geo Mashup later than 1.2.4.', 'GeoMashupCustom' ) .
					'<br/>';
			}
			$this->found_files = get_option( 'geo_mashup_custom_found_files' );
			if ( empty( $this->found_files ) ) {
				$this->found_files = $this->rescue_files();
				update_option( 'geo_mashup_custom_found_files', $this->found_files );
			}
		}
	}

	/**
	 * Rescue known custom files from the Geo Mashup folder.
	 */
	function rescue_files() {
		$results = array( 'ok' => array(), 'failed' => array() );
		$check_files = array( 'custom.js', 'map-style.css', 'info-window.php', 'full-post.php', 'user.php', 'comment.php' );
		foreach( $check_files as $file ) {
			if ( !isset( $this->files[$file] ) ) {
				$endangered_file = trailingslashit( GEO_MASHUP_DIR_PATH ) . $file;
				if ( is_readable( $endangered_file ) ) {
					$safe_file = trailingslashit( $this->dir_path ) . $file; 
					if ( copy( $endangered_file, $safe_file ) ) {
						$this->file[$file] = trailingslashit( $this->url_path ) . $file;
						array_push( $results['ok'], $file );
					} else {
						array_push( $results['failed'], $file );
					}
				}
			}
		}
		return $results;
	}

	/**
	 * Display any messages after the plugin row.
	 * 
	 * @param object $plugin_data Plugin data.
	 * @param string $context 'active', 'inactive', etc.
	 */
	function after_plugin_row( $plugin_data = null, $context = '' ) {
		if ( !empty( $_GET['geo_mashup_custom_list'] ) ) {
			echo '<tr><td colspan="5">' . __( 'Current custom files: ', 'GeoMashupCustom') .
				implode( ', ', array_keys( $this->files ) ) . '</td></tr>';
		}
		if ( !empty( $this->warnings ) ) {
			echo '<tr><td colspan="5">' . $this->warnings . '</td></tr>';
		}
	}

	/**
	 * Get the URL of a custom file if it exists.
	 *
	 * @param string $file The custom file to check for.
	 * @return URL or false if the file is not found.
	 */
	function file_url( $file ) {
		$url = false;
		if ( isset( $this->files[$file] ) ) {
			$url = $this->files[$file];
		}
		return $url;
	}

} // end Geo Mashup Custom class

// Instantiate
$geo_mashup_custom = new GeoMashupCustom();

} // end if Geo Mashup Custom class exists

function trail_story_locations_json_filter( $json_properties, $queried_object ) {

    $post_id = $queried_object->object_id;

    $post_type = get_post_type( $post_id );
/*
    if ( $post_type == 'trail-story' ) {

        $json_properties['my_complete'] = 1;

    } else if ( $post_type == 'trail-condition' ) {

        $json_properties['my_complete'] = 2;

    } else if ( $post_type == 'itinerary' ) {

        $json_properties['my_complete'] = 3;

    } else {

        $json_properties[''];

    }

   return $json_properties;*/

    switch ( $post_type ) {

        case 'trail-story':
            $json_properties['my_complete'] = 1;
            return $json_properties;
            break;

        case 'trail-condition':
            $json_properties['my_complete'] = 2;
            return $json_properties;
            break;

        case 'itinerary':
            $json_properties['my_complete'] = 3;
            return $json_properties;
            break;

        default:
            $json_properties[''];
            return $json_properties;

    }

}

add_filter( 'geo_mashup_locations_json_object','trail_story_locations_json_filter', 10, 2 );