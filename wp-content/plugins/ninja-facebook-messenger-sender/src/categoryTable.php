<?php
if (!defined('ABSPATH')) {
    exit;
}
class NjtFbMessSenderTable extends WP_List_Table {

    public $info = array();

    public function get_columns()
    {
        return array(
                    'cb' => '<input type="checkbox" />',
                    //'id' => __('ID', NJT_FB_MESS_I18N),
                    'name' => __('Name', NJT_FB_MESS_I18N),
                    'description' => __('Description', NJT_FB_MESS_I18N),
                    'count' => __('Count', NJT_FB_MESS_I18N),
                );
    }
    public function prepare_items()
    {
        global $wpdb;
        require_once NJT_FB_MESS_DIR . '/src/category.class.php';

        $per_page = $this->get_items_per_page('njt_fb_mess_category_per_page', 20);
        $current_page = $this->get_pagenum();

        /*
         * CONDITIONS
         */
        $where = array("1 = 1");
        if (isset($_REQUEST['s']) && !empty($_REQUEST['s'])) {
            $where[] = "`name` LIKE '%".addslashes($_REQUEST['s'])."%'";
        }
        
        /*
         * End conditions
         */
        
        $total = $wpdb->get_var("SELECT COUNT(*) FROM ".$wpdb->prefix."njt_fb_mess_categories WHERE ".implode(' AND ', $where)."");

        $this->set_pagination_args(array(
            'total_items' => $total,                  //WE have to calculate the total number of items
            'per_page'    => $per_page                     //WE have to determine how many items to show on a page
        ));

        $order = $this->get_order();

        $_cates = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."njt_fb_mess_categories WHERE ".implode(' AND ', $where)." ORDER BY ".$order." LIMIT ".(($current_page - 1) * $per_page).", ".$per_page."");

        $_cates2 = array();
        njt_fb_mess_sender_proccess_array_tr($_cates, $_cates2, '-');

        $cates = array();
        foreach ($_cates2 as $k => $v) {
            $cates[] = array(
                'id' => $v->id,
                'name' => $v->name,
                'description' => $v->description,
                'count' => NjtFbMessCategory::getCountSender($v->id),
            );
        }

        $hidden = array();
        $sortable = $this->get_sortable_columns();

        $this->_column_headers = $this->get_column_info();
        $this->items = $cates;
    }
    public function column_default($item, $column_name)
    {
        return ((in_array($column_name, array_keys($this->get_columns()))) ? $item[$column_name] : print_r($item, true));
    }
    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'id'  => array('id', false),//false means ASC, true means DESC or unordered
            'name'  => array('name', false)
        );
        return $sortable_columns;
    }
    public function get_order() {
        // If no sort, default to id
        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'id';
        // If no order, default to asc
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'desc';
        
        return $orderby . ' ' . $order;
    }
    public function column_name($item) {
        $edit_link = add_query_arg(array('page' => $this->info['cate_page_slug'], 'action' => 'edit', 'id' => $item['id']), admin_url('admin.php'));
        $delete_link =  add_query_arg(array('page' => $this->info['cate_page_slug'], 'action' => 'delete', 'id[]' => $item['id']), admin_url('admin.php'));
        $actions = array(
            'edit' => sprintf('<a href="%2$s">'.__('Edit', NJT_FB_MESS_I18N).'</a>', $item['id'], $edit_link),
            'delete' => sprintf(
                '<a onclick="return confirm(\'%4$s\');" href="%2$s">%3$s</a>',
                $item['id'],
                $delete_link,
                __('Delete', NJT_FB_MESS_I18N),
                __('Are you sure?', NJT_FB_MESS_I18N)
            )
        );
        return sprintf('%1$s %2$s', $item['name'], $this->row_actions($actions));
    }
    public function get_bulk_actions() {
        $actions = array(
            'delete'    => __('Delete', NJT_FB_MESS_I18N),
        );
        return $actions;
    }
    public function column_cb($item) {
        return sprintf('<input type="checkbox" name="id[]" value="%s" />', $item['id']);
    }
}
