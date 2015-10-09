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
add_shortcode( 'frontend_trail_story_map', 'trail_story_post_form_handler' );

function trail_story_post_form_handler(){

    if ( isset( $_POST['trail_story_post_action'] ) && ( isset( $_POST['trail_story_add_post_nonce_field'] ) || wp_verify_nonce( $_POST['trail_story_add_post_nonce_field'], 'trail_story_post_nonce' ) ) ) {
     
        add_action( 'init', 'trail_story_save_post_form' );
     
    } else {

        trail_story_post_form();

    }

}

function trail_story_post_form() {
    // Create form ?>
        <div class="trail-story-form-wrapper">

            <form id="new_post" name="new_post" method="post" action="" class="trail-story-form" enctype="multipart/form-data">
                <fieldset name="map">
                    <?php //GeoMashupUIManager::enqueue_form_client_items(); ?>
                    <?php //GeoMashupUIManager::enqueue_jquery_styles(); ?>
                    <?php GeoMashupUserUIFrontend::get_instance()->print_form(); ?>
                </fieldset>

                <fieldset name="name">
                    <label for="title"> <h3><?php _e( 'Trail Story Title', 'geo-mashup-trail-story-add-on' ); ?></h3></label>
                    <input type="text" id="title" value="" tabindex="5" name="title" />
                </fieldset>
         
                <fieldset class="category">
                    <label for="cat"><h3><?php _e( 'Trail Story Chapter', 'geo-mashup-trail-story-add-on' ); ?></h3></label>
                    <?php wp_dropdown_categories( 'tab_index=10&taxonomy=trail-story-category&hide_empty=0&echo=1' ); ?>
                </fieldset>
             
                <fieldset class="content">
                    <label for="description"><h3><?php _e( 'Description', 'geo-mashup-trail-story-add-on' );?></h3></label>
                    <textarea id="description" tabindex="15" name="description" cols="80" rows="10"></textarea>
                </fieldset>
             
                <!--<fieldset class="tags">
                    <label for="post_tags">Additional Keywords (comma separated):</label>
                    input type="text" value="" tabindex="35" name="post_tags" id="post_tags" />
                </fieldset>-->
             
                <fieldset class="submit">
                    <input type="submit" value="Post Story" tabindex="40" id="submit" name="submit" />
                </fieldset>

                <?php wp_nonce_field( 'trail_story_post_nonce', 'trail_story_add_post_nonce_field' ); ?>
             
                <input type="hidden" name="trail_story_post_action" value="true" />

            </form>

        </div>
<?php
}

function trail_story_save_post_form() {

    if ( trim( $_POST['title'] ) === '' ) {
        $postTitleError = 'Please enter a title.';
        $hasError = true;
    }
 
    $post_information = array(
        'post_title' => wp_strip_all_tags( $_POST['title'] ),
        'post_content' => $_POST['description'],
        'post_type' => 'trail-story',
        'post_status' => 'pending'
    );
    var_dump($post_information);
    $post_id = wp_insert_post( $post_information );

    if ( $post_id ) {
        $pid = get_permalink( $post_id );
        wp_redirect( $pid );
        exit;
    }

}
