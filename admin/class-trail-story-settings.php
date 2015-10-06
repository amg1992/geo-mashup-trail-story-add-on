<?php
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

        //add_submenu_page(
            //'edit.php?post_type=product',
            //'Out of Stock Report',
            //'Out of Stock Report',
            //'manage_options',
            //'outofstock-stats'//,
            //array( $this, 'create_trail_story_menu_page' )
        //);

    }

    /**
     * Options page callback
     */
    public function create_trail_story_menu_page()
    {
        // Set class property
        $this->options = get_option( 'trail_story_settings_option' );
        ?>
        <div class="wrap">
            <h2>Woo Out of Stock</h2>
            <form method="post" action="options.php">

            <?php
                // This prints out all hidden setting fields
                settings_fields( 'trail_story_settings_option_group' );
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
            'trail_story_settings_option_group', // Option group
            'trail_story_settings_option', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'trail_story_settings_section', // ID
            'Out of Stock Product Statistics', // Title
            array( $this, 'print_section_info' ), // Callback
            'trail-story-setting-admin' // Page
        );

        add_settings_field(
            'trail_story_option', // ID
            'Trail Story Option', // Title
            array( $this, 'trail_story_option_callback' ), // Callback
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

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print '<br/><p style="font-size:14px; margin:0 25% 0 0;"><strong>Options coming soon!</strong>';
    }
    /**
     * Get the settings option array and print one of its values
     */
    public function trail_story_option_callback()
    {
        //Get plugin options
        $options = get_option( 'trail_story_settings_option' );

        if (isset($options['trail_story_option'])) {
            $html .= '<input type="checkbox" id="trail_story_option"
             name="trail_story_settings_option[trail_story_option]" value="1"' . checked( 1, $options['trail_story_option'], false ) . '/>';
        } else {
            $html .= '<input type="checkbox" id="trail_story_option"
             name="trail_story_settings_option[trail_story_option]" value="1"' . checked( 1, $options['trail_story_option'], false ) . '/>';
        }

        echo $html;
    }
}

if( is_admin() )
    $trail_story = new TrailStorySettings();
