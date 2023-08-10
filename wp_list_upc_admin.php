<?php

class UPC_admin_table extends WP_List_Table
{
    private $table_data;

    function get_columns()
    {
        $columns = [
            'name' => 'Nom',
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
        switch ($column_name) {
            case 'id':
            case 'name':
                return $item[$column_name];
            case 'enabled':
                $checked = !empty($item[$column_name]) ? 'checked="checked"' : '';
                return "<input type='checkbox' value='1' {$checked} />";
        }
    }

    private function get_table_data()
    {
        global $wpdb;
        $table = $wpdb->prefix . 'permission_control';

        return $wpdb->get_results("
            SELECT t.name, tt.parent, upc.enabled
            FROM {$wpdb->prefix}term_taxonomy tt
            INNER JOIN {$wpdb->prefix}terms_taxonomy tts ON tts.term_id = t.term_id
            INNER JOIN {$wpdb->prefix}terms t t.term_id ON = tt.term_id
            LEFT JOIN {$table} upc ON upc.thing_id = t.term_id
            WHERE tt.taxonomy = 'category'
        ");
    }
}