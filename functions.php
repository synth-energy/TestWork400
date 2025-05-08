<?php
if (!defined('ABSPATH')) exit;

/**
 * Подключение стилей родительской темы
 */
add_action('wp_enqueue_scripts', 'storefront_child_enqueue_styles');
function storefront_child_enqueue_styles() {
    wp_enqueue_style('storefront-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('storefront-child-style', get_stylesheet_uri(), array('storefront-style'));
}

/**
 * Подключение функциональных модули
 */
require_once get_stylesheet_directory() . '/inc/cpt-cities.php';
require_once get_stylesheet_directory() . '/inc/meta-cities.php';
require_once get_stylesheet_directory() . '/inc/taxonomy-countries.php';
require_once get_stylesheet_directory() . '/inc/widget-weather.php';
require_once get_stylesheet_directory() . '/inc/hooks-weather.php';
require_once get_stylesheet_directory() . '/inc/ajax.php';
require_once get_stylesheet_directory() . '/inc/scripts.php';