<?php
/**
 * Регистрация пользовательской таксономии "Countries"
 */
function register_taxonomy_countries() {
    $labels = array(
        'name'              => 'Countries',
        'singular_name'     => 'Country',
        'search_items'      => 'Search Countries',
        'all_items'         => 'All Countries',
        'parent_item'       => 'Parent Country',
        'parent_item_colon' => 'Parent Country:',
        'edit_item'         => 'Edit Country',
        'update_item'       => 'Update Country',
        'add_new_item'      => 'Add New Country',
        'new_item_name'     => 'New Country Name',
        'menu_name'         => 'Countries',
    );

    $args = array(
        'hierarchical'      => true, // true = как категории, false = как теги
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'country'),
        'show_in_rest'      => true,
    );

    register_taxonomy('country', array('city'), $args);
}
add_action('init', 'register_taxonomy_countries');
