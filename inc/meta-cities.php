<?php
if (!defined('ABSPATH')) exit;

/**
 * Регистрируем метабокс для широты и долготы
 */
function add_city_coordinates_metabox() {
    add_meta_box(
        'city_coordinates',
        'Координаты города',
        'render_city_coordinates_metabox',
        'city',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'add_city_coordinates_metabox');

/**
 * Отображение HTML формы в метабоксе
 */
function render_city_coordinates_metabox($post) {
    // Получаем сохранённые значения
    $latitude  = get_post_meta($post->ID, '_city_latitude', true);
    $longitude = get_post_meta($post->ID, '_city_longitude', true);

    // Защита
    wp_nonce_field('save_city_coordinates', 'city_coordinates_nonce');
    ?>
    <p>
        <label for="city_latitude">Широта:</label><br>
        <input type="text" id="city_latitude" name="city_latitude" value="<?php echo esc_attr($latitude); ?>" style="width: 100%;">
    </p>
    <p>
        <label for="city_longitude">Долгота:</label><br>
        <input type="text" id="city_longitude" name="city_longitude" value="<?php echo esc_attr($longitude); ?>" style="width: 100%;">
    </p>
    <?php
}

/**
 * Сохраняем значения при сохранении записи
 */
function save_city_coordinates_meta($post_id) {
    // Проверка nonce
    if (!isset($_POST['city_coordinates_nonce']) || !wp_verify_nonce($_POST['city_coordinates_nonce'], 'save_city_coordinates')) {
        return;
    }

    // Проверка автосохранения
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Проверка прав доступа
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Сохраняем данные
    if (isset($_POST['city_latitude'])) {
        update_post_meta($post_id, '_city_latitude', sanitize_text_field($_POST['city_latitude']));
    }

    if (isset($_POST['city_longitude'])) {
        update_post_meta($post_id, '_city_longitude', sanitize_text_field($_POST['city_longitude']));
    }
}
add_action('save_post', 'save_city_coordinates_meta');
