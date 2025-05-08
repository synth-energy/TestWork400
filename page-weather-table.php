<?php
/**
 * Template Name: Weather Table Page
 */

get_header();

// Подключаем API ключ
$api_key = '742cd2d3402dc1829b435713b6f25f08';

global $wpdb;

// Запросим все города с координатами
$cities = $wpdb->get_results("
    SELECT p.ID, p.post_title, lat.meta_value AS latitude, lon.meta_value AS longitude
    FROM {$wpdb->prefix}posts p
    LEFT JOIN {$wpdb->prefix}postmeta lat ON (p.ID = lat.post_id AND lat.meta_key = '_city_latitude')
    LEFT JOIN {$wpdb->prefix}postmeta lon ON (p.ID = lon.post_id AND lon.meta_key = '_city_longitude')
    WHERE p.post_type = 'city' AND p.post_status = 'publish'
");

// Хук перед таблицей
do_action('before_weather_table');

?>

<div class="weather-page-content">
    <h1>Погода по городам</h1>

    <?php do_action('before_cities_table'); ?>

    <input type="text" id="city-search" placeholder="Поиск по городам..." />

    <table id="weather-table" border="1" cellpadding="10" style="margin-top: 20px;">
        <thead>
        <tr>
            <th>Страна</th>
            <th>Город</th>
            <th>Температура (°C)</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cities as $city): ?>
            <?php
            $country_terms = wp_get_post_terms($city->ID, 'country', array('fields' => 'names'));
            $country_name = !empty($country_terms) ? implode(', ', $country_terms) : '—';

            $lat = esc_attr($city->latitude);
            $lon = esc_attr($city->longitude);
            $temp = '—';

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
            ?>
            <tr>
                <td><?php echo esc_html($country_name); ?></td>
                <td><?php echo esc_html($city->post_title); ?></td>
                <td><?php echo esc_html($temp); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php do_action('after_cities_table'); ?>
</div>

<?php
// Хук после таблицы
do_action('after_weather_table');

get_footer(); ?>
