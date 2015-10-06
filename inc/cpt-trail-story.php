<?php
/*
* Custom Post Type for Trail Story
*/
add_action( 'init', 'register_cpt_trail_story' );

function register_cpt_trail_story() {

    $labels = array( 
        'name' => _x( 'Trail Story', 'trail-story' ),
        'singular_name' => _x( 'Trail Story', 'trail-story' ),
        'add_new' => _x( 'Add New Trail Story', 'trail-condition' ),
        'add_new_item' => _x( 'Add New Trail Story', 'trail-story' ),
        'edit_item' => _x( 'Edit Trail Story', 'trail-story' ),
        'new_item' => _x( 'New Trail Condition', 'trail-story' ),
        'view_item' => _x( 'View Trail Condition', 'trail-story' ),
        'search_items' => _x( 'Search Trail Conditions', 'trail-story' ),
        'not_found' => _x( 'No Trail Conditions found', 'trail-story' ),
        'not_found_in_trash' => _x( 'No Trail Conditions found in Trash', 'trail-story' ),
        'parent_item_colon' => _x( 'Parent Trail Conditions:', 'trail-story' ),
        'menu_name' => _x( 'Trail Conditions', 'trail-story' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ), // 'custom-fields' , 'excerpt' 
        'taxonomies' => array( 'trail-story-category'), //, 'post_tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-cloud',//'dashicons-controls-volumeon', //'dashicons-media-audio',
        'has_archive' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => 'trail-conditions' ),
        'capability_type' => 'post'
    );

    register_post_type( 'trail-condition', $args );
}


/**
* Taxonomy for Trail Condition CPT categories
*/
add_action( 'init', 'register_txn_trail_story' );

function register_txn_trail_story() {

    $labels = array( 
        'name' => _x( 'Trail Condition Category', 'trail-story-category' ),
        'singular_name' => _x( 'Trail Condition Category', 'trail-story-category' ),
        'search_items' => _x( 'Search Trail Condition Categories', 'trail-story-category' ),
        'popular_items' => _x( 'Popular Trail Condition Categories', 'trail-story-category' ),
        'all_items' => _x( 'All Trail Condition Categories', 'trail-story-category' ),
        'parent_item' => _x( 'Parent Trail Condition Category', 'trail-story-category' ),
        'parent_item_colon' => _x( 'Parent Trail Condition Category:', 'trail-story-category' ),
        'edit_item' => _x( 'Edit Trail Condition Category', 'trail-story-category' ),
        'update_item' => _x( 'Update Trail Condition Category', 'trail-story-category' ),
        'add_new_item' => _x( 'Add New', 'trail-story-category' ),
        'new_item_name' => _x( 'New Trail Condition Category', 'trail-story-category' ),
        'separate_items_with_commas' => _x( 'Separate Trail Condition Categories with commas', 'trail-story-category' ),
        'add_or_remove_items' => _x( 'Add or remove Trail Condition Categories', 'trail-story-category' ),
        'choose_from_most_used' => _x( 'Choose from the most used Trail Condition Category', 'trail-story-category' ),
        'menu_name' => _x( 'Condition Categories', 'trail-story-category' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_tagcloud' => true,
        'show_admin_column' => false,
        'hierarchical' => true,
        'rewrite' => array( 'slug' => 'story-category' ),
        'query_var' => true
    );

    register_taxonomy( 'trail-story-category', array('trail-story'), $args );
}