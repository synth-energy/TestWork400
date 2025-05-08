<?php
if (!defined('ABSPATH')) exit;

/**
 * Регистрация кастомного типа записи "Cities"
 */
function register_cpt_cities() {
    $labels = array(
        'name'               => 'Cities',
        'singular_name'      => 'City',
        'menu_name'          => 'Cities',
        'name_admin_bar'     => 'City',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New City',
        'new_item'           => 'New City',
        'edit_item'          => 'Edit City',
        'view_item'          => 'View City',
        'all_items'          => 'All Cities',
        'search_items'       => 'Search Cities',
        'parent_item_colon'  => 'Parent Cities:',
        'not_found'          => 'No cities found.',
        'not_found_in_trash' => 'No cities found in Trash.'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'cities'),
        'menu_icon'          => 'dashicons-location-alt',
        'supports'           => array('title', 'editor', 'thumbnail'),
        'show_in_rest'       => true // для поддержки Gutenberg и REST API
    );

    register_post_type('city', $args);
}
add_action('init', 'register_cpt_cities');
