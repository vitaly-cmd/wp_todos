<?php

class WP_Todo_Database {
    private static $table_name = 'wp_todos';

    public static function create_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            user_id mediumint(9) NOT NULL,
            title text NOT NULL,
            completed boolean NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }

    public static function insert_todos($todos) {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;

        foreach ($todos as $todo) {
            $wpdb->insert($table_name, [
                'user_id' => $todo['userId'],
                'title' => $todo['title'],
                'completed' => $todo['completed']
            ]);
        }
    }

    public static function get_uncompleted_todos($limit = 5) {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;

        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE completed = 0 ORDER BY id DESC LIMIT %d", $limit);
        return $wpdb->get_results($query);
    }

    public static function search_todos($title) {
        global $wpdb;
        $table_name = $wpdb->prefix . self::$table_name;

        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE title LIKE %s", '%' . $wpdb->esc_like($title) . '%');
        return $wpdb->get_results($query);
    }
}
