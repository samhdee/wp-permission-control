<?php

/**
 *  Plugin name: Permission control
 */

register_activation_hook( __FILE__, 'upc_activation_hook');

function upc_activation_hook()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'permission_control';
    $query = "CREATE TABLE IF NOT EXISTS {$table_name} (
            `id` int(9) NOT NULL AUTO_INCREMENT,
            `permissions` text NOT NULL,
            `type` text NOT NULL,
            `enabled` tinyint(1),
            `deleted` TINYINT(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (id)
        ) {$charset_collate}";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta($query);
    return empty($wpdb->last_error);
}

add_action('admin_menu', 'upc_permission_menu');

function upc_permission_menu()
{
    add_users_page(
        'Permissions',
        'Permissions par role',
        'edit_users',
        'permissions_plugin',
        'upc_users_content',
    );
}

function upc_users_content()
{
    if (!current_user_can('edit_users')) {
        return;
    }

    $tab = isset($_GET['tab']) ? $_GET['tab'] : '';

    include('views/main.php');
}