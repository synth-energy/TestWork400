<?php
// Функция для вывода перед таблицей
function custom_before_weather_table() {
    echo '<div class="custom-before-table-message"><h1>Welcome to the weather table!</h1></div>';
}

add_action('before_weather_table', 'custom_before_weather_table');

// Функция для вывода после таблицей
function custom_after_weather_table() {
    echo '<div class="custom-after-table-message"><h4>Thank you for checking the weather!</h4></div>';
}

add_action('after_weather_table', 'custom_after_weather_table');
