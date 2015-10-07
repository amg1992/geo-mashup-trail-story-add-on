<?php
/**
 * Creates the Front End form for users to create a Tail Story post
 * 
 * @package Geo Mashup Trail Story Add-On
*/

// Exit if accessed directly
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

/**
* Shortcode for display frontend user trail story input
*/
add_shortcode( 'frontend_trail_story_map', 'trail_story_post_form' );

function trail_story_post_form() {
    // Create form ?>
        <div class="trail-story-form-wrapper">

            <form id="new_post" name="new_post" method="post" action="" class="trail-story-form" enctype="multipart/form-data">
                <fieldset name="map">
                    <?php GeoMashupUserUIManager::get_instance()->print_form(); ?>
                </fieldset>

                <fieldset name="name">
                    <label for="title"> <?php _e( 'Trail Story Title', 'geo-mashup-trail-story-add-on' ); ?></label>
                    <input type="text" id="title" value="" tabindex="5" name="title" />
                </fieldset>
         
                <fieldset class="category">
                    <label for="cat"> <?php _e( 'Trail Story Chapter', 'geo-mashup-trail-story-add-on' ); ?> </label>
                    <?php wp_dropdown_categories( 'tab_index=10&taxonomy=trail-story-category&hide_empty=0&echo=1' ); ?>
                </fieldset>
             
                <fieldset class="content">
                    <label for="description">Description</label>
                    <textarea id="description" tabindex="15" name="description" cols="80" rows="10"></textarea>
                </fieldset>
             
                <!--<fieldset class="tags">
                    <label for="post_tags">Additional Keywords (comma separated):</label>
                    input type="text" value="" tabindex="35" name="post_tags" id="post_tags" />
                </fieldset>-->

                
             
                <fieldset class="submit">
                    <input type="submit" value="Post Story" tabindex="40" id="submit" name="submit" />
                </fieldset>
             
                <input type="hidden" name="action" value="new_post" />
                <?php wp_nonce_field( 'new-post' ); ?>

            </form>

        </div>
<?php
}

function trail_story_sanitize_post_form_data() {
    // Sanitizes input form data
}

function trail_story_save_post_form() {
    // Save form data as post
}

if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_post") {
    trail_story_sanitize_post_form_data();
}
