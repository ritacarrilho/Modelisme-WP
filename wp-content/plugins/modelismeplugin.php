<?php
/**
 * Plugin Name: Modelisme Plugin 
 * Description: Occitanie Modelisme Plugin
 * Author: Rita 
 * Version: 1.0.0
 */

/**
 * ficheiro de entrada no qual se vai poder aceder a outras classes, ficheiros de funções, etc, primeiro a ser carregado quando se activa ao plugin - composto por uma classe (é quase equivalente do ficheiro functions do tema) - é possivel chamar o hook e adicionar coisas do plugin
 */

require_once plugin_dir_path(__FILE__) . 'service/Modelisme_Database_service.php';

class Modelisme 
{
    public function __construct() {
        // plugin activation: tables creation
        register_activation_hook(__FILE__, array('Modelisme_Database', 'create_db'));  //catches the plugin activation (class name, method of table creation)

        add_action('admin-menu', [$this, 'add_menu_client']); // add the client menu to the wp interface
    }

    public function add_menu_client() {
        add_menu_page('Page title', 'Modelisme', 'manage_options', 'occitanieModelisme', array($this, "modelisme_competition"), "dashicons-groups", 40);
    }

    public function modelisme_competition() {
        echo "<h2>" . get_admin_page_title() . "</h2>";
    }
}

new Modelisme ();
?>