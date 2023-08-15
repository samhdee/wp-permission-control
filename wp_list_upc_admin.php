<?php

if (!class_exists('WP_List_Table')) {
      require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

class UPC_admin_table extends WP_List_Table
{
    private $table_data;

    function get_columns()
    {
        return [
            'name' => 'Nom/rôle',
            'type' => 'Type',
            'enabled' => 'Activé',
            'delete' => 'Supprimer',
        ];
    }

    function prepare_items()
    {
        $this->_column_headers = [
            $this->get_columns(),
            [],
            [],
            'name'
        ];
        $this->items = $this->table_data = $this->get_table_data();
    }

    function column_default($item, $column_name)
    {
        $types = [
            'category' => 'Catégorie',
            'post_tag' => 'Étiquette',
            'post' => 'Post',
        ];

        switch ($column_name) {
            case 'name':
                return $item[$column_name];
            case 'type':
                return TYPES_LIST[$item[$column_name]];
            case 'enabled':
                $checked = !empty($item[$column_name]) ? 'checked="checked"' : '';
                return "<input type='checkbox' value='1' {$checked} />";
            case 'delete':
                return "<button>Supprimer</button>";
        }
    }

    private function get_table_data()
    {
        global $wpdb;

        return $wpdb->get_results("
            SELECT t.name, tt.parent,  wpc.type, wpc.enabled
            FROM {$wpdb->prefix}term_taxonomy tt
            INNER JOIN {$wpdb->prefix}terms_taxonomy tts ON tts.term_id = t.term_id
            INNER JOIN {$wpdb->prefix}terms t t.term_id ON = tt.term_id
            LEFT JOIN {$wpdb->prefix}permission_control wpc ON wpc.thing_id = t.term_id
            LEFT JOIN {$wpdb->prefix}usermeta um ON um.umeta_id = wpc.thing_id
            WHERE tt.taxonomy = 'category'
            AND upc.deleted <> 1
        ", ARRAY_A);
    }
}