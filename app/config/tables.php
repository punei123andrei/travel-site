<?php

// Extra needed tables
add_action('after_switch_theme', function () {
    // global $wpdb;
    // $table_name = $wpdb->prefix.'campaign';
    // $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
    //     id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
    //     phone VARCHAR(10) NOT NULL,
    //     timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    //     PRIMARY KEY  (id)
    //     );";
    //
    // if (!function_exists('dbDelta')) {
    //     require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    // }
    // dbDelta($sql);
});
