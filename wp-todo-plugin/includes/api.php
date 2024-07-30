<?php

class WP_Todo_API {
    const API_URL = 'https://jsonplaceholder.typicode.com/todos';

    public static function fetch_todos() {
        $response = wp_remote_get(self::API_URL);
        if (is_wp_error($response)) {
            WP_Todo_Logger::log('error', 'Failed to fetch todos from API');
            return false;
        }

        $body = wp_remote_retrieve_body($response);
        $todos = json_decode($body, true);
        return $todos;
    }
}
