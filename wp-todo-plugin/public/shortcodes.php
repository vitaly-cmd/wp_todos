<?php

add_shortcode('recent_uncompleted_todos', function () {
    $todos = WP_Todo_Database::get_uncompleted_todos();
    ob_start();
    if (!empty($todos)) {
        echo '<ul>';
        foreach ($todos as $todo) {
            echo '<li>' . esc_html($todo->title) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No uncompleted todos found.</p>';
    }
    return ob_get_clean();
});
