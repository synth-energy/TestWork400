# Storefront Child Theme — Cities Weather Project

## 📌 Описание

Дочерняя тема для Storefront, реализующая кастомный функционал: пользовательский тип записи **Cities**, произвольные поля координат, таксономию **Countries**, виджет с отображением текущей температуры (через OpenWeatherMap API), страницу с таблицей стран/городов/температуры и AJAX-поиск по городам.

## 💡 Требования

- WordPress 6.0+
- PHP 7.4+
- Установленная и активированная родительская тема [Storefront](https://wordpress.org/themes/storefront/)
- API-ключ от [OpenWeatherMap](https://openweathermap.org/api)

## ⚙ Установка

1. Скопируйте содержимое темы `storefront-child` в директорию `wp-content/themes/`.
2. Активируйте тему через **Внешний вид → Темы**.
3. Перейдите в **Виджеты** и добавьте **Weather Widget** в любую доступную область.
4. Убедитесь, что у вас добавлены записи типа "Cities" с заполненными метаполями `latitude` и `longitude`.
5. Создайте страницу и назначьте ей шаблон `Weather Table` для отображения таблицы с AJAX-поиском.

## 🧱 Структура проекта

storefront-child/
├── assets/
│ └── js/
│ └── weather-search.js ← Скрипт для AJAX-поиска
├── inc/
│ ├── ajax.php ← AJAX-обработка поиска
│ ├── cpt-cities.php ← Регистрация типа записи "Cities"
│ ├── meta-cities.php ← Метаполя широты и долготы
│ ├── scripts.php ← Подключение скриптов и переменных JS
│ ├── taxonomy-countries.php ← Таксономия "Countries"
│ └── widget-weather.php ← Виджет погоды
├── page-templates/
│ └── page-weather-table.php ← Шаблон страницы с таблицей и поиском
├── functions.php ← Подключает всё из inc/
└── style.css ← Стили дочерней темы


## ✅ Реализованный функционал

- **Custom Post Type:** `Cities`
- **Meta Box:** поля `latitude`, `longitude` в редакторе записи
- **Taxonomy:** `Countries`, привязана к `Cities`
- **Виджет:** выбор города и отображение температуры через OpenWeatherMap
- **Custom Template:** таблица со странами/городами/температурой
- **AJAX-поиск:** по названиям городов с использованием `$wpdb`
- **Custom Action Hooks:**
    - `before_weather_table` — до вывода таблицы
    - `after_weather_table` — после таблицы

## 📝 Примечания

- Для отображения температуры необходимо указать API-ключ в коде виджета (`widget-weather.php`).
- Все файлы структурированы по назначению для удобной поддержки и масштабирования.
- Код документирован и оптимизирован под выполнение в рамках темы без использования сторонних плагинов.

---

