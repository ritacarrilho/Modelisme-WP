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

require_once plugin_dir_path(__FILE__) . 'modelisme/service/Modelisme_Database_service.php';

class Modelisme 
{
    public function __construct() {
        // plugin activation: tables creation
        register_activation_hook(__FILE__, array('Modelisme_Database_service', 'create_db'));  //catches the plugin activation (class name, method of table creation)

        add_action('admin_menu', [$this, 'add_menu_modelisme']); // add the client menu to the wp interface
    }

    public function add_menu_modelisme() {
        add_menu_page(
            "Modelisme Occitanie", 
            "Modelisme", 
            "manage_options", 
            "occitanieModelisme", 
            array($this, 'modelisme_competition'), 
            "dashicons-car", 
            40
        );
// add submenus to the client menu
       add_submenu_page(
           'occitanieModelisme',
           'All Occitanie Clubs', 
           'Clubs', 
           'manage_options', 
           'addClub', 
           [$this, 'modelisme_clubs']
        ); 

        add_submenu_page(
            'occitanieModelisme',
            'The Club\'s Members', 
            'Members', 
            'manage_options', 
            'addMember', 
            [$this, 'modelisme_members']
         ); 

         add_submenu_page(
            'occitanieModelisme',
            'Competition\'s Categories', 
            'Categories', 
            'manage_options', 
            'addCategory', 
            [$this, 'modelisme_categories']
         ); 

         add_submenu_page(
            'occitanieModelisme',
            'Scores', 
            'Scores', 
            'manage_options', 
            'addScore', 
            [$this, 'modelisme_scores']
         ); 
    }

    public function modelisme_competition() {
        echo "<h2>" . get_admin_page_title() . "</h2>";

        $db = new Modelisme_Database_service; // call the DB
        
    }

    public function modelisme_clubs() {
        echo "<h2>" . get_admin_page_title() . "</h2>";

    }

    public function modelisme_members() {
        echo "<h2>" . get_admin_page_title() . "</h2>";

    }    
    
    public function modelisme_categories() {
        echo "<h2>" . get_admin_page_title() . "</h2>";

    }

    public function modelisme_scores() {
        echo "<h2>" . get_admin_page_title() . "</h2>";

    }
}

new Modelisme ();
?>