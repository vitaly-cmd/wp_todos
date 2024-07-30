<?php

add_action('admin_menu', function () {
    add_menu_page('WP Todo Plugin', 'Todo Plugin', 'manage_options', 'wp-todo-plugin', 'wp_todo_plugin_page');
});

function wp_todo_plugin_page() {
    ?>
    <div class="wrap">
        <h1>WP Todo Plugin</h1>
        <form method="post" action="">
            <?php wp_nonce_field('sync_todos', 'sync_todos_nonce'); ?>
            <input type="submit" name="sync_todos" class="button button-primary" value="Sync Todos">
        </form>
        <form method="get" action="">
            <input type="hidden" name="page" value="wp-todo-plugin">
            <input type="text" name="s" placeholder="Search by title" value="<?php echo isset($_GET['s']) ? esc_attr($_GET['s']) : ''; ?>">
            <input type="submit" class="button button-secondary" value="Search">
        </form>
        <?php
        // Обработка синхронизации данных
        if (isset($_POST['sync_todos']) && check_admin_referer('sync_todos', 'sync_todos_nonce')) {
            $todos = WP_Todo_API::fetch_todos();
            if ($todos) {
                WP_Todo_Database::insert_todos($todos);
                echo '<div class="notice notice-success is-dismissible"><p>Todos synced successfully.</p></div>';
            } else {
                echo '<div class="notice notice-error is-dismissible"><p>Failed to sync todos.</p></div>';
            }
        }

        // Обработка поиска
        if (isset($_GET['s']) && !empty($_GET['s'])) {
            $search_results = WP_Todo_Database::search_todos($_GET['s']);
            echo '<h2>Search Results</h2>';
            if (!empty($search_results)) {
                echo '<ul>';
                foreach ($search_results as $todo) {
                    echo '<li>' . esc_html($todo->title) . '</li>';
                }
                echo '</ul>';
            } else {
                echo '<p>No todos found with that title.</p>';
            }
        }
        ?>
    </div>
    <?php
}
