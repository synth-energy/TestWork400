<?php
if (!defined('ABSPATH')) exit;

/**
 * Виджет отображает температуру выбранного города
 */
class Weather_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'weather_widget',
            'Погода в городе',
            array('description' => 'Показывает текущую температуру для выбранного города.')
        );
    }

    /**
     * Вывод на фронтенде
     */
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $city_id = !empty($instance['city_id']) ? absint($instance['city_id']) : 0;
        $api_key = '742cd2d3402dc1829b435713b6f25f08'; // 🔁 ВСТАВЬ СЮДА СВОЙ КЛЮЧ

        if ($city_id) {
            $city_name = get_the_title($city_id);
            $lat = get_post_meta($city_id, '_city_latitude', true);
            $lon = get_post_meta($city_id, '_city_longitude', true);

            echo $args['before_title'] . esc_html($city_name) . $args['after_title'];

            if ($lat && $lon) {
                $api_url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&units=metric&lang=ru&appid=$api_key";

                $response = wp_remote_get($api_url);
                if (!is_wp_error($response)) {
                    $data = json_decode(wp_remote_retrieve_body($response), true);
                    if (isset($data['main']['temp'])) {
                        echo '<p>Температура: ' . esc_html($data['main']['temp']) . '°C</p>';
                    } else {
                        echo '<p>Не удалось получить температуру.</p>';
                    }
                } else {
                    echo '<p>Ошибка API.</p>';
                }
            } else {
                echo '<p>Координаты не заданы.</p>';
            }
        } else {
            echo '<p>Город не выбран.</p>';
        }

        echo $args['after_widget'];
    }

    /**
     * Форма в админке
     */
    public function form($instance) {
        $city_id = !empty($instance['city_id']) ? absint($instance['city_id']) : '';
        $cities = get_posts(array(
            'post_type'      => 'city',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ));
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('city_id')); ?>">Выберите город:</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('city_id')); ?>" name="<?php echo esc_attr($this->get_field_name('city_id')); ?>">
                <option value="">— Не выбрано —</option>
                <?php foreach ($cities as $city): ?>
                    <option value="<?php echo esc_attr($city->ID); ?>" <?php selected($city_id, $city->ID); ?>>
                        <?php echo esc_html($city->post_title); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }

    /**
     * Сохран настроек
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['city_id'] = (!empty($new_instance['city_id'])) ? absint($new_instance['city_id']) : '';
        return $instance;
    }
}

/**
 * Регистрация виджета
 */
function register_weather_widget() {
    register_widget('Weather_Widget');
}
add_action('widgets_init', 'register_weather_widget');
