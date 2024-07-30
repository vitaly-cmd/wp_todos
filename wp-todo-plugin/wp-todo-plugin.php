<?php
/*
Plugin Name: WP Todo Plugin
Description: A plugin to integrate with external API and display TODOs.
Version: 1.0
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require_once plugin_dir_path(__FILE__) . 'includes/api.php';
require_once plugin_dir_path(__FILE__) . 'includes/database.php';
require_once plugin_dir_path(__FILE__) . 'includes/logger.php';
require_once plugin_dir_path(__FILE__) . 'admin/admin-menu.php';
require_once plugin_dir_path(__FILE__) . 'public/shortcodes.php';

// Активируем плагин
register_activation_hook(__FILE__, 'wp_todo_plugin_activate');

function wp_todo_plugin_activate() {
    WP_Todo_Database::create_table();
}

add_action('plugins_loaded', function () {
    WP_Todo_Logger::initialize();
});
