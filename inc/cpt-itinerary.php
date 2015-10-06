<?php
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );
/*
* Custom Post Type for Itinerary
*/
add_action( 'init', 'register_cpt_itinerary' );

public static function register_cpt_itinerary() {

    $labels = array( 
        'name' => _x( 'Itinerary', 'itinerary' ),
        'singular_name' => _x( 'Itinerary', 'itinerary' ),
        'add_new' => _x( 'Add New', 'itinerary' ),
        'add_new_item' => _x( 'Add New Itinerary', 'itinerary' ),
        'edit_item' => _x( 'Edit Itinerary', 'itinerary' ),
        'new_item' => _x( 'New Itinerary', 'itinerary' ),
        'view_item' => _x( 'View Itinerary', 'itinerary' ),
        'search_items' => _x( 'Search Itineraries', 'itinerary' ),
        'not_found' => _x( 'No Itineraries found', 'itinerary' ),
        'not_found_in_trash' => _x( 'No Itineraries found in Trash', 'itinerary' ),
        'parent_item_colon' => _x( 'Parent Itineraries:', 'itinerary' ),
        'menu_name' => _x( 'Itineraries', 'itinerary' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ), // 'custom-fields' , 'excerpt' 
        'taxonomies' => array( 'intineraries'), //, 'post_tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => false,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-location-alt',//'dashicons-controls-volumeon', //'dashicons-media-audio',
        'has_archive' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'slug' => 'itinerary' ),
        'capability_type' => 'post'
    );

    register_post_type( 'itinerary', $args );
}


/**
* Taxonomy for Itinerary CPT categories
*/
add_action( 'init', 'register_txn_itinerary' );

public static function register_txn_itinerary() {

    $labels = array( 
        'name' => _x( 'Itinerary Category', 'intineraries' ),
        'singular_name' => _x( 'Itinerary Category', 'intineraries' ),
        'search_items' => _x( 'Search Itinerary Categories', 'intineraries' ),
        'popular_items' => _x( 'Popular Itinerary Categories', 'intineraries' ),
        'all_items' => _x( 'All Itinerary Categories', 'intineraries' ),
        'parent_item' => _x( 'Parent Itinerary Category', 'intineraries' ),
        'parent_item_colon' => _x( 'Parent Itinerary Category:', 'intineraries' ),
        'edit_item' => _x( 'Edit Itinerary Category', 'intineraries' ),
        'update_item' => _x( 'Update Itinerary Category', 'intineraries' ),
        'add_new_item' => _x( 'Add New', 'intineraries' ),
        'new_item_name' => _x( 'New Itinerary Category', 'intineraries' ),
        'separate_items_with_commas' => _x( 'Separate Itinerary Categories with commas', 'intineraries' ),
        'add_or_remove_items' => _x( 'Add or remove Itinerary Categories', 'intineraries' ),
        'choose_from_most_used' => _x( 'Choose from the most used Itinerary Category', 'intineraries' ),
        'menu_name' => _x( 'Itinerary Categories', 'intineraries' ),
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
        'rewrite' => array( 'slug' => 'itinerary-category' ),
        'query_var' => true
    );

    register_taxonomy( 'intineraries', array('itinerary'), $args );
}
