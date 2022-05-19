<?php
if(! class_exists('WP_List_Table')) { // prevent bug
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
} 

require_once plugin_dir_path(__FILE__) ."/service/Modelisme_Database_service.php";

class Club_List extends WP_List_Table 
{
    private $dal;

    public function __construct( $args = array())
    {
        parent::__construct( [
            'singular' => __('Client'),
            'plural' => __('Clients')
        ]);

        $this->dal = new Modelisme_Database_service;
    }

    public function prepare_items()
    {
        // variaveis para construir a tabela
        $columns = $this->get_columns();

        $hidden = $this->get_hidden_columns();

        $sortable = $this->get_sortable_columns();

        // paginaçao
        $per_page = $this->get_items_per_page('client_per_page', 20); // n* de clients a affichar em cada pagina
        $current_page = $this->get_pagenum(); // envia o numero da pagina em que estamos

        // dados
        // $data = $this->dal->findAllAndAddress('clubs');
        $data = $this->dal->findClubDomain();

       $total_pages = count($data); 

        // tri 
        usort($data, array(&$this, 'usort_reorder')); // triagem de dados - modifica directamente os dados
                                    // (dados, (pagina actual - 1 porque o array começa a 0 * n de elementos por pagina, adiciona o n de elementos para a proxima affichage (proxima parte do array), neste caso 10 + 10)
        $data_pagination = array_slice($data, (($current_page - 1) * $per_page), $per_page); 
        $this->set_pagination_args([
            'total_items' => '$total_pages',
            'per_page' => '$per_page',
        ]);

        $this->_column_headers = [$columns, $hidden, $sortable];
        $this->items = $data_pagination;
    }

    public function column_default($item, $column_name) { // hidrataçao de dados - procurar o valor na tabela em funçao do index - cada linha transforma-se num objecto
        // show data in table
        // var_dump($column_name);

        switch($column_name) {
            case 'id':
            case 'name':
            case 'cat_domain':
                return $item->$column_name;
                break;
            case 'participant':
                return ($item->$column_name == 0) ? "Club in not participant" : "Club is participant";
                break;
            default:
                return print_r($item, true);
        }
    } 

    public function usort_reorder($a, $b) { // compara os dois valores
        // coluna sobre a qual vamos triar
        $order_by = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'id'; // representa a variavel passada em get (propriedade a triar)
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc'; // crescente ou descrescente
        $result = strcmp($a->$order_by, $b->$order_by); // resultado de comparaçao feito dinamicamente (metodo dinamico) - sobre a coluna triavel ou sobre o id (retorna a ordem) 

        return ($order === 'asc') ? $result : -$result; // se a ordem é ascendente retorna result senao retorna o inverso de result (- é possivel porque strcmp() retorna um int)
    }

    public function get_columns() { // predifinir todos os elementos das colunas e retornar o valor
        $columns = [
            'id' => 'id',
            'name' => 'Name',
            'cat_domain' => 'Domaine',
            'participant' => 'Participant'
        ];

        return $columns;
    }

    public function get_hidden_columns() { // masker campos que nao queremos mostrar
        return []; // neste caso como nao vamos maskar nada, retorna uma array vazio
    }

    public function get_sortable_columns() {
        // triagem do que se afficha ou nao no backoffice (ex mostrar consoante o id ou o nome) - definir os campos que é possivel fazer triagem ou nao
        return $sortable = [ 'id' => ['id', true], 
                            'name' => ['name', true],
                            'domaine' => ['domaine', true],
                            'participant' => ['participant', true]
        ];
    }
}