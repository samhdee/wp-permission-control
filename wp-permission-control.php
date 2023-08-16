<?php
/**
 *  Plugin name: Permission control
 */
const TYPES_LIST = [
    'category' => 'Catégorie',
    'post_tag' => 'Étiquette',
    'post' => 'Post',
];
const ROLES_LIST = [
    'contributor' => 'Contributeur·rice',
    'author' => 'Auteur·rice',
    'editor' => 'Éditeur·rice',
];

require __DIR__ . '/wp_list_upc_admin.php';

// Actions à l'activation du plugin
function wpc_activation_hook()
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

register_activation_hook( __FILE__, 'wpc_activation_hook');

// Ajoute le menu des permissions dans Comptes
function wpc_permission_menu()
{
    add_users_page(
        'Permissions',
        'Permissions par role',
        'edit_users',
        'permissions_plugin',
        'upc_users_content',
    );
}

add_action('admin_menu', 'wpc_permission_menu');

// Ajout Javascript
function add_js($hook) {
    wp_register_script(
        'wpc_js', plugin_dir_url(__FILE__) . '/includes/wp-permission-control.js',
        ['jquery']
    );
    wp_localize_script('wpc_js', 'wpcAjax', ['ajaxurl' => admin_url('admin-ajax.php')]);
    wp_enqueue_script('wpc_js');
}

add_action('admin_enqueue_scripts', 'add_js');

// Ajout CSS
function admin_css() {
	wp_enqueue_style('admin-styles', plugin_dir_url(__FILE__) . 'includes/wp-permission-control.css');
}

add_action('admin_enqueue_scripts', 'admin_css');

// Affiche la page d'admin des permissions
function upc_users_content()
{
    if (!current_user_can('edit_users')) {
        return;
    }

    $table = new UPC_admin_table();
    $table->prepare_items();

    include('includes/main.php');
}

// Submit formulaire d'ajout
add_action('admin_action_wpc_add_action', 'wpc_add_action');
add_action('wp_ajax_nopriv_get_my_post', 'wpc_add_action');

function wpc_add_action()
{
    // Do your stuff here
    wp_redirect($_SERVER['HTTP_REFERER']);
    exit();
}

// AJAX search
add_action('wp_ajax_wpc_search', 'wpc_search');

function wpc_search()
{
    $targets = ['user', 'role', 'page', 'post', 'post_tag', 'category'];

    if (
        empty($_POST)
        || empty($_POST['target'])
        || !in_array($_POST['target'], $targets)
        || empty($_POST['value'])
    ) {
        echo json_encode(['success' => false]);
        die;
    }

    global $wpdb;

    switch ($_POST['target']) {
        case 'user':
            echo json_encode($wpdb->get_results("
                SELECT ID as id, CONCAT (user_nicename, ' (', user_login, ')') as name
                FROM {$wpdb->prefix}users
                WHERE user_login LIKE '{$_POST['value']}%'
                OR user_nicename LIKE '{$_POST['value']}%'
                ORDER BY user_nicename
            "));
            die;

        case 'post':
        case 'page':
            echo json_encode($wpdb->get_results("
                SELECT ID as id, post_title as name
                FROM {$wpdb->prefix}posts
                WHERE post_title LIKE '{$_POST['value']}%'
                AND post_type = '{$_POST['target']}'
                AND post_status <> 'trash'
                ORDER BY post_title
            "));
            die;
            break;

        case 'post_tag':
        case 'category':
            echo json_encode($wpdb->get_results("
                SELECT t.term_id as id, t.name
                FROM {$wpdb->prefix}terms t
                INNER JOIN {$wpdb->prefix}term_taxonomy tt ON tt.term_id = t.term_id
                WHERE tt.taxonomy = '{$_POST['target']}'
                AND t.name LIKE '{$_POST['value']}%'
                ORDER BY t.name
            "));
            die;
            break;
    }
}

// Ajout
add_action('admin_action_wpc_add', 'wpc_add');

function wpc_add()
{
    global $wpdb;
    echo '<pre>'; print_r($_POST); die;
}
