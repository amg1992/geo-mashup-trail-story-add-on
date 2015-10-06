<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );
/**
* PLUGIN SETTINGS PAGE
*/
class TrailStorySettings
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_trail_story_menu_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_trail_story_menu_page()
    {
        // This page will be under "Settings"add_submenu_page( 'tools.php', 'SEO Image Tags', 'SEO Image Tags', 'manage_options', 'seo_image_tags', 'seo_image_tags_options_page' );
        add_menu_page(
            'Trail Story',
            'Trail Story',
            'manage_options',
            'trail-story',
            array( $this, 'create_trail_story_menu_page' ),
            plugins_url('geo-mashup-trail-story-add-on/assets/icon-20x20.png'), 100
        );

        add_submenu_page(
            'trail-story',
            'Itineraries',
            'Itineraries',
            'manage_options',
            'edit.php?post_type=itinerary'
        );

        add_submenu_page(
            'trail-story',
            'Trail Stories',
            'Trail Stories',
            'manage_options',
            'edit.php?post_type=trail-story'
        );

        add_submenu_page(
            'trail-story',
            'Trail Conditions',
            'Trail Conditions',
            'manage_options',
            'edit.php?post_type=trail-condition'
        );

        add_submenu_page(
            'trail-story',
            'Settings',
            'Settings',
            'manage_options',
            'trail-story-settings',
            array( $this, 'create_trail_story_settings_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_trail_story_menu_page()
    {
        // Set class property
        $this->options = get_option( 'trail_story_option' );
        ?>
        <div class="wrap">
            <h2>Options</h2>
            <form method="post" action="options.php">

            <?php
                // This prints out all hidden setting fields
                settings_fields( 'trail_story_options_group' );
                do_settings_sections( 'trail-story-options-admin' );
                submit_button('Save Options');
            ?>
            </form>
        </div>
        <?php
    }

     /**
     * Options page callback
     */
    public function create_trail_story_settings_page()
    {
        // Set class property
        $this->options = get_option( 'trail_story_settings' );
        ?>
        <div class="wrap">
            <h2>Settings</h2>
            <form method="post" action="options.php">

            <?php
                // This prints out all hidden setting fields
                settings_fields( 'trail_story_settings_group' );
                do_settings_sections( 'trail-story-setting-admin' );
                submit_button('Save Settings');
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'trail_story_options_group', // Option group
            'trail_story_options', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        register_setting(
            'trail_story_settings_group', // Option group
            'trail_story_settings', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'trail_story_options_section', // ID
            'Options Section', // Title
            array( $this, 'print_option_info' ), // Callback
            'trail-story-options-admin' // Page
        );

        add_settings_section(
            'trail_story_settings_section', // ID
            'Settings Section', // Title
            array( $this, 'print_section_info' ), // Callback
            'trail-story-setting-admin' // Page
        );

        add_settings_field(
            'trail_story_option', // ID
            'Trail Story Option', // Title
            array( $this, 'trail_story_option_callback' ), // Callback
            'trail-story-options-admin', // Page
            'trail_story_options_section' // Section
        );

        add_settings_field(
            'trail_story_setting', // ID
            'Trail Story Setting', // Title
            array( $this, 'trail_story_setting_callback' ), // Callback
            'trail-story-setting-admin', // Page
            'trail_story_settings_section' // Section
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();

        if( isset( $input['trail_story_option'] ) )
            $new_input['trail_story_option'] = absint( $input['trail_story_option'] );

        if( isset( $input['trail_story_setting'] ) )
            $new_input['trail_story_setting'] = absint( $input['trail_story_setting'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_option_info()
    {
        print '<br/><p style="font-size:14px; margin:0 25% 0 0;"><strong>Developed at <a href="http://orionweb.net" target="_blank">Orion Group</a> LLC by '.
         '<a href="http://andrewmgunn.com" target="_blank">Andrew Gunn</a>, Ryan Van Ess, Jon Valcq, and Josh Selk</strong>';
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        //print '<br/><p style="font-size:14px; margin:0 25% 0 0;"><strong>Options coming soon!</strong>';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function trail_story_option_callback()
    {
        //Get plugin options
        $options = get_option( 'trail_story_options' );

        if (isset($options['trail_story_option'])) {
            $html .= '<input type="checkbox" id="trail_story_option"
             name="trail_story_options[trail_story_option]" value="1"' . checked( 1, $options['trail_story_option'], false ) . '/>';
        } else {
            $html .= '<input type="checkbox" id="trail_story_option"
             name="trail_story_options[trail_story_option]" value="1"' . checked( 1, $options['trail_story_option'], false ) . '/>';
        }

        echo $html;
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function trail_story_setting_callback()
    {
        //Get plugin options
        $options = get_option( 'trail_story_settings' );

        if (isset($options['trail_story_option'])) {
            $html .= '<input type="checkbox" id="trail_story_settings"
             name="trail_story_settings[trail_story_setting]" value="1"' . checked( 1, $options['trail_story_setting'], false ) . '/>';
        } else {
            $html .= '<input type="checkbox" id="trail_story_settings"
             name="trail_story_settings[trail_story_setting]" value="1"' . checked( 1, $options['trail_story_setting'], false ) . '/>';
        }

        echo $html;
    }
}

if( is_admin() )
    $trail_story = new TrailStorySettings();
