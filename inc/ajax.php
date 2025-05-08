<?php
// Обработчик AJAX-запроса для поиска по городам
add_action('wp_ajax_search_cities', 'handle_search_cities');
add_action('wp_ajax_nopriv_search_cities', 'handle_search_cities');

function handle_search_cities() {
    global $wpdb;

    $keyword = sanitize_text_field($_POST['keyword']);
    $api_key = '742cd2d3402dc1829b435713b6f25f08';

    // Запрос на получение городов из базы данных
    $query = "
        SELECT p.ID, p.post_title, lat.meta_value AS latitude, lon.meta_value AS longitude
        FROM {$wpdb->prefix}posts p
        LEFT JOIN {$wpdb->prefix}postmeta lat ON (p.ID = lat.post_id AND lat.meta_key = '_city_latitude')
        LEFT JOIN {$wpdb->prefix}postmeta lon ON (p.ID = lon.post_id AND lon.meta_key = '_city_longitude')
        WHERE p.post_type = 'city' AND p.post_status = 'publish'
    ";

    // Если есть поисковый запрос, добавляем фильтрацию по названию города
    if (!empty($keyword)) {
        $query .= $wpdb->prepare(" AND p.post_title LIKE %s", '%' . $wpdb->esc_like($keyword) . '%');
    }

    $cities = $wpdb->get_results($query);

    // Выводим данные для таблицы
    foreach ($cities as $city) {
        $country_terms = wp_get_post_terms($city->ID, 'country', array('fields' => 'names'));
        $country_name = !empty($country_terms) ? implode(', ', $country_terms) : '—';

        $lat = esc_attr($city->latitude);
        $lon = esc_attr($city->longitude);
        $temp = '—';

        // Получаем температуру с помощью API
        if ($lat && $lon) {
            $url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&units=metric&lang=ru&appid=$api_key";
            $response = wp_remote_get($url);
            if (!is_wp_error($response)) {
                $data = json_decode(wp_remote_retrieve_body($response), true);
                if (isset($data['main']['temp'])) {
                    $temp = round($data['main']['temp'], 1);
                }
            }
        }

        // Отправляем строку таблицы для города
        echo '<tr>';
        echo '<td>' . esc_html($country_name) . '</td>';
        echo '<td>' . esc_html($city->post_title) . '</td>';
        echo '<td>' . esc_html($temp) . '</td>';
        echo '</tr>';
    }

    // Завершаем выполнение AJAX-запроса
    wp_die();
}
