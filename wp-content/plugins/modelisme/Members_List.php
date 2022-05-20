<?php
if(! class_exists('WP_List_Table')) { // prevent bug
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
} 

require_once plugin_dir_path(__FILE__) ."/service/Modelisme_Database_service.php";

class Members_List extends WP_List_Table 
{
    private $dal;

    public function __construct( $args = array())
    {
        parent::__construct( [
            'singular' => __('Member'),
            'plural' => __('Members')
        ]);

        $this->dal = new Modelisme_Database_service;
    }

    public function prepare_items()
    {
        $columns = $this->get_columns();

        $hidden = $this->get_hidden_columns();

        $sortable = $this->get_sortable_columns();

        // paginaçao
        $per_page = $this->get_items_per_page('client_per_page', 10); 
        $current_page = $this->get_pagenum(); 

        // data
        $data = $this->dal->findMembers();
        // echo '<pre>'; var_dump($data);
       $total_pages = count($data); 

        // tri 
        usort($data, array(&$this, 'usort_reorder')); 
        $data_pagination = array_slice($data, (($current_page - 1) * $per_page), $per_page); 
        $this->set_pagination_args([
            'total_items' => $total_pages,
            'per_page' => $per_page,
        ]);

        $this->_column_headers = [$columns, $hidden, $sortable];
        $this->items = $data_pagination;
    }

    public function column_default($item, $column_name) {
        switch($column_name) {
            case 'id':
            case 'last_name':
            case 'first_name':
            case 'email':
            case 'phone':
            case 'name':
                return $item->$column_name;
                break;
            default:
                return print_r($item, true);
        }
    } 

    public function get_columns() { 
        $columns = [
            'id' => 'id',
            'last_name' => 'Last Name',
            'first_name' => 'First Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'name' => 'Club Name',
        ];

        return $columns;
    }

    public function get_hidden_columns() {
        return []; 
    }

    public function get_sortable_columns() {
        return $sortable = [ 'id' => ['id', true], 
                            'last_name' => ['last_name', true],
        ];
    }
}