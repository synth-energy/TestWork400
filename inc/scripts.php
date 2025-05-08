<?php
function enqueue_weather_search_script() {
    if (is_page_template('page-weather-table.php')) {
        wp_enqueue_script('weather-search', get_stylesheet_directory_uri() . '/assets/js/weather-search.js', array(), null, true);
        wp_localize_script('weather-search', 'ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php')
        ));
    }
}
add_action('wp_enqueue_scripts', 'enqueue_weather_search_script');
