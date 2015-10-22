<?php
	/*
	 * Plugin Name: Require Email for Download
	 * Description: Barebones plugin for requiring emails for downloads.
	 * Author: Faison
	 * Author URI: http://faisonz.com
	 * Version: 0.1
	 */


	/*
	 *	Three Main Parts of this Plugin
	 *		-	Adding download restrictions to Media
	 *		-	Creating download keys for Media
	 *		-	Serving Media as direct download when presented with a valid download key
	 *
	 */

	/*
	 *
	 *	Example Filters, uncomment to see what happens
	 *
	 */

	/*
	add_filter( 'e4d_download_wrapper', 'e4d_time' );
	function e4d_time( $download_wrapper ) {
		return '<pre>Time: ' . time() . ' url: <a href="%1$s" target="_blank">%1$s</a></pre>';
	}
	*/

	/*
	add_filter( 'e4d_download_page', 'e4d_page' );
	function e4d_page( $download_page ) {
		return "{$download_page}/download/";
	}
	*/

	/*
	add_filter( 'e4d_failed_download_page', 'e4d_fail_page' );
	function e4d_fail_page( $download_page ) {
		return "/download-expired/";
	}
	*/

	if( ! function_exists( 'got_mod_rewrite' ) ) {
    	require_once( ABSPATH . 'wp-admin/includes/file.php' );
    	require_once( ABSPATH . 'wp-admin/includes/misc.php' );
	}

	class Email_For_Download {

		private $table_name;

		function __construct() {

			register_activation_hook( __FILE__, array( $this, 'install' ) );
			register_uninstall_hook( __FILE__, 'Email_For_Download::uninstall' );

			if( got_mod_rewrite() ) {
				//	Activate Plugin Features
				add_shortcode( 'e4d_get_url', array( $this, 'get_url' ) );

				add_filter( 'attachment_fields_to_edit', array( $this, 'add_attachment_fields' ), 10, 2 );
				add_filter( 'attachment_fields_to_save', array( $this, 'save_attachment_fields' ), 10, 2 );

				add_action( 'pre_get_posts', array( $this, 'pre_get_posts' ) );
				add_action( 'wp', array( $this, 'serve_a_file' ) );

				add_action( 'wp_head', array( $this, 'add_file_refresh' ) );

			} else {
				//	Display Warning and activate no features
			}
		}





		function install() {
			global $wpdb;

			$this->table_name = $wpdb->prefix . 'e4d';

			$create_sql =	"CREATE TABLE {$this->table_name} (
								download_key varchar(32) NOT NULL unique,
								media_id bigint(20) NOT NULL default'0',
								email varchar(255) NOT NULL default '',
								downloads int UNSIGNED NOT NULL default '0',
								expires int UNSIGNED NOT NULL default '0'
							);";
			
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $create_sql );

		}

		static function uninstall() {
			global $wpdb;

			$table_name = $wpdb->prefix . 'e4d';
			do_action( 'e4d_before_table_drop', $table_name );
			$wpdb->query( "DROP TABLE IF EXISTS {$table_name}" );

			$htaccess_file = get_home_path() . '.htaccess';
			$rules = array();
			insert_with_markers( $htaccess_file, 'e4d', $rules );

			delete_post_meta_by_key( '_e4d_require' );
		}






		function is_required( $attachment_id ) {
			return get_post_meta( $attachment_id, "_e4d_require", true);
		}

		function get_attachment_dir( $attachment_id ) {
			$url = wp_get_attachment_url( $attachment_id );
			$uploads = wp_upload_dir();
			$file_path = str_replace( $uploads['baseurl'], $uploads['basedir'], $url );
			return $file_path;
		}

		function add_attachment_fields( $form_fields, $post ) {

			$require = $this->is_required( $post->ID );

			$form_fields["e4d_require"] = array();
			$form_fields["e4d_require"]["label"] = __("Require Email For Download?");  
			$form_fields["e4d_require"]["input"] = "html";  
			$form_fields["e4d_require"]["html"] = "<input type='radio' value='1'
			name='attachments[{$post->ID}][e4d_require]' id='attachments[{$post->ID}][e4d_require]1' " . 
			checked( true, $require, false ) . " /> <label for='attachments[{$post->ID}][e4d_require]1'>Yes</label>";
			$form_fields["e4d_require"]["html"] .= " <input type='radio' value='0'
			name='attachments[{$post->ID}][e4d_require]' id='attachments[{$post->ID}][e4d_require]0' " . 
			checked( false, $require, false ) . " /> <label for='attachments[{$post->ID}][e4d_require]0'>No</label>";

			return $form_fields;
		}

		function save_attachment_fields( $post, $attachment ) {
		    if( isset($attachment['e4d_require']) ){
	            update_post_meta($post['ID'], '_e4d_require', $attachment['e4d_require'] == 1 );

	            $dir = $this->get_attachment_dir( $post['ID'] );
	            $dir = explode( '/wp-content/', $dir );
	            $file_path = "/wp-content/{$dir[1]}";

	            if( $attachment['e4d_require'] == 1 ) {
	            	$this->add_restriction( $file_path );
	            } else {
	            	$this->remove_restriction( $file_path );
	            }
		    }
		    return $post;
		}




		/*
		 *	Just an easy way for getting the location of the WP .htaccess file
		 */
		function get_htaccess() {
			return get_home_path() . '.htaccess' ;
		}

		/*
		 *	This function is used to determine if the file path exists in the e4d
		 *	restriction block in the WP .htaccess file. If found, it will return the
		 *	line number (starting at zero), otherwise it will return -1 for not found.
		 */
		function get_restriction_line( $file_path ) {
			$rules = $this->get_restrictions();
			for( $i = 0; $i < count( $rules ); $i++ ) {
				$rule = $rules[ $i ];
				$restrict_path = str_replace( 'Redirect 403 ', '', $rule );
				if( $file_path == $restrict_path ) {
					return $i;
				}
			}
			return -1;
		}

		/*
		 *	This uses extract_from_markers to get all restriction block from the
		 *	WP .htaccess file
		 */
		function get_restrictions() {
			$htaccess_file = $this->get_htaccess();

			return extract_from_markers( $htaccess_file, 'e4d' );
		}

		/*
		 *	First, we check if the restriction already exists, leaving the
		 *
		 */
		function add_restriction( $file_path ) {
			if( $this->get_restriction_line( $file_path ) != -1 ) {
				return;
			}

			$htaccess_file = $this->get_htaccess();

			$rules = $this->get_restrictions();
			$rules[] = "Redirect 403 {$file_path}";

			insert_with_markers( $htaccess_file, 'e4d', $rules );
		}

		function remove_restriction( $file_path ) {
			$rest_line = $this->get_restriction_line( $file_path );
			if( $rest_line == -1 ) {
				return;
			}

			$htaccess_file = $this->get_htaccess();

			$rules = $this->get_restrictions();

			unset( $rules[ $rest_line ] );
			$rules = array_values( $rules );

			insert_with_markers( $htaccess_file, 'e4d', $rules );

		}

		/*
		 *	This function will be used to keep people from loading attachment pages for 
		 *	restricted attachments
		 */
		function pre_get_posts( $query ) {
			/*
			if( $query->is_attachment ) {
				if( $query->get( 'attachment_id' ) ) {
					if( $this->is_required( $query->get( 'attachment_id' ) ) ) {
						$query->set( 'attachment_id', null );
					}
				}
			}
			*/
		}





		function get_download_page() {
			return apply_filters( 'e4d_download_page', get_site_url() );
		}

		function get_failed_download_page() {
			return apply_filters( 'e4d_failed_download_page', get_site_url() );
		}


		/*
		 *
		 *
		 */
		function create_key(){
			//create a random key
			$strKey = md5( microtime() );

			if( $this->is_key_valid( $strKey ) ) {
				//key already in use
				return createKey();
			}else{
				//key is OK
				return $strKey;
			}
		}

		/*
		 *
		 *
		 */
		function get_existing_token( $attachment_id, $email ) {
			global $wpdb;

			$table_name = $wpdb->prefix . 'e4d';

			$token = $wpdb->get_row( $wpdb->prepare(
				"SELECT * FROM {$table_name} WHERE media_id = %d AND email = %s",
				$attachment_id, $email
			) );

			if( $this->is_token_valid( $token ) ) {
				return $token->download_key;
			} else {
				return null;
			}
		}

		/*
		 *
		 *
		 */
		function is_token_valid( $token ) {
			if( !$token ) {

				return false;
			} else if( time() > $token->expires ) {

				$this->invalidate_key( $token->download_key );
				return false;
			}
			return true;
		}

		/*
		 *
		 *
		 */
		function invalidate_key( $dl_key ) {
			global $wpdb;

			$table_name = $wpdb->prefix . 'e4d';
			$result = $wpdb->query( $wpdb->prepare(
				"DELETE FROM {$table_name} WHERE download_key = %s",
				$dl_key
			) );

		}

		/*
		 *
		 *
		 */
		function create_download_token( $attachment_id, $email ) {
			$token = $this->get_existing_token( $attachment_id, $email );
			if( $token ) {
				return $token;
			}

			global $wpdb;
			$table_name = $wpdb->prefix . 'e4d';

			$token = $this->create_key();

			$wpdb->insert(
				$table_name,
				array(
					'download_key' => $token,
					'media_id' => $attachment_id,
					'email' => $email,
					'downloads' => 0,
					'expires' => (time()+(60*60*24*7))
				),
				array(
					'%s', '%d', '%s', '%d', '%d'
				)
			);

			return $token;
		}

		// Add Shortcode
		function get_url( $atts ) {

			// Attributes
			extract( shortcode_atts(
				array(
					'attachment_id' => '-1',
					'email' => false
				), $atts
			) );

			$output = '';
			$dl_key = null;

			if( $attachment_id == -1 || !$email ) {

			} else {

				// Code
				$dl_key = $this->create_download_token( $attachment_id, $email );

				$download_wrapper = apply_filters( 'e4d_download_wrapper', "<pre>%s</pre>" );
				$download_string = apply_filters( 'e4d_download_string', $this->get_download_page() . "?e4d={$dl_key}", $dl_key );

				$output = sprintf( $download_wrapper, $download_string );

			}
			return apply_filters( 'e4d_download_output', $output, $dl_key );
		}


		function get_filename_from_path( $file_path ) {

			$filename = explode( DIRECTORY_SEPARATOR, $file_path );
			$filename = $filename[ count( $filename ) - 1 ];

			return $filename;

		}

		function increment_download_count( $dl_key ) {
			global $wpdb;

			$table_name = $wpdb->prefix . 'e4d';

			$wpdb->query( $wpdb->prepare(
				"UPDATE {$table_name} SET downloads = downloads + 1 WHERE download_key = %d",
				$dl_key
			) );

		}

		function serve_file( $attachment_id ) {
			$file_path = $this->get_attachment_dir( $attachment_id );
			if( !is_file( $file_path ) ) {
				return;
			}

			$mime = get_post_mime_type( $attachment_id );
			$filename = $this->get_filename_from_path( $file_path );

			header( "Content-Type: {$mime}" );
			header( 'Content-Disposition: attachment;filename='.$filename);
			ob_start();

			$file = fopen( $file_path, 'r' );
			while ( !feof( $file ) ) {
			   $line = fgets( $file );
			   echo $line;
			}

			$contLength = ob_get_length();
			header( 'Content-Length: '.$contLength);

		}

		function is_key_valid( $dl_key ) {
			global $wpdb;

			$table_name = $wpdb->prefix . 'e4d';

			$count = $wpdb->get_var( $wpdb->prepare(
				"SELECT count(*) AS count FROM {$table_name} WHERE download_key = %s AND expires > %d LIMIT 1",
				$dl_key, time()
			) );

			if( $count == 1 ) {
				return true;
			} else {
				$this->invalidate_key( $dl_key );
				return false;
			}

		}

		function get_media_id_for_key( $dl_key ) {
			global $wpdb;

			$table_name = $wpdb->prefix . 'e4d';

			$media_id = $wpdb->get_var( $wpdb->prepare(
				"SELECT media_id FROM {$table_name} WHERE download_key = %s LIMIT 1",
				$dl_key
			) );

			return $media_id;
		}

		function serve_a_file( $wp ) {
			if( !isset( $_REQUEST['e4d'] ) ) {
				return;
			}

			$dl_key = $_REQUEST['e4d'];

			if( !$this->is_key_valid( $dl_key) ) {
				wp_redirect( $this->get_failed_download_page() ); exit;
			}

			$media_id = $this->get_media_id_for_key( $dl_key );

			if( isset( $_REQUEST['e4d_action'] ) && $_REQUEST['e4d_action'] == 'download' ) {
				if( $media_id ) {
					$this->serve_file( $media_id );
					//$this->increment_download_count( $dl_key );
				}
			}
		}

		function add_file_refresh() {
			if( !isset( $_REQUEST['e4d'] ) ) {
				return;
			}

			$dl_key = $_REQUEST['e4d'];

			if( !$this->is_key_valid( $dl_key) ) {
				return;
			}

			$media_id = $this->get_media_id_for_key( $dl_key );

			if( isset( $_REQUEST['e4d_action'] ) && $_REQUEST['e4d_action'] == 'download' ) {
				return;
			} else {
				if( $media_id ) {
					$query_string = sprintf( '?e4d=%1$s&e4d_action=download', $dl_key );
					echo sprintf( '<meta http-equiv="refresh" content="1;URL=%1$s" />', $query_string );//header("Refresh: 3;?e4d={$dl_key}&e4d_action=download");
				}
			}
		}


	}

	new Email_For_Download();