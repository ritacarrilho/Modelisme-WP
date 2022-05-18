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
require_once plugin_dir_path(__FILE__) . 'modelisme/Club_List.php';


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

        $db = new Modelisme_Database_service; // appel du service de base

        // if($_REQUEST['page'] == 'ernClient' || $_POST['send'] == 'ok' || $_POST['action'] == 'del') { // $_REQUEST nao interessa se é POST ou GET || se o formulario ofr enviado o input hidden envia em post 'send' = 'ok'


        //     if(isset($_POST['send']) && $_POST['send'] == 'ok') { // guardar dados do form na tabela, isset evita ter uma warning
        //         $db->save_club();
        //     }

        //     if(isset($_POST['action']) && $_POST['action'] == 'del') { // guardar dados do form na tabela
        //         $db->delete_club($_POST['id']);
        //     }

        $table = new Club_List;
            $table->prepare_items();
            echo $table->display(); // gera o html da tabela para ser possivel affichardd

            echo '<input type="button" value="Show details" class="btn btn-outline-secondary"/>';

            // começa o display da tabela - cabeçalho
            echo '<table class="table-striped ">';
            echo '<thead>';
            echo '<tr>';
            echo '<th scope="col"><strong>ID</strong><th>';
            echo '<th scope="col"><strong>Name</strong><th>';
            echo '<th scope="col"><strong>Email</strong><th>';
            echo '<th scope="col"><strong>Phone</strong><th>';
            echo '<th scope="col"><strong>Domaine</strong><th>';
            echo '<th scope="col"><strong>Address</strong><th>';
            echo '<th scope="col"><strong>Participant</strong><th>';
            echo '</tr>';
            echo '</thead>';
            // echo '<pre>'; var_dump($_POST); echo '</pre>';

            foreach($db->findAll('clubs') as $club) { // afficher lista de todos os clients presentes na tabela com botao de delete
                echo '<tr>';
                echo '<td>' . $club->id . '<td>';
                echo '<td>' . $club->name . '<td>';
                echo '<td>' . $club->email . '<td>';
                echo '<td>' . $club->phone . '<td>';
                echo '<td>' . $db->findClubDomain()->name . '<td>';
                // var_dump($db->findAddressPerClub($club->id));
                echo '<td>' . $db->findAddressPerClub($club->id)->street . ", " . $db->findAddressPerClub($club->id)->city . ", " . $db->findAddressPerClub($club->id)->zip_code . '<td>';

                echo '<td>' . (($club->participant === 0) ? "Club in not participant" : "Club is participant") . '<td>';
                echo '<td><form method="post">' .
                            '<input type="hidden" name="action" value="del" />' . 
                            '<input type="hidden" name="id" value="' . $club->id .'" />' . 
                            '<input type="submit" value="del"/>' .
                    '</form></td>';
                echo '</tr>'; }
            
            echo '</table>';
        // } else  {
            echo '<form method="post">' . 
            '<input type="hidden" name="send" value="ok"/>' .
            '<div><label for="name"> Name : </label>' . 
            '<input type="text" id="name" name="name" class="widefat" required /></div>' .

            '<div><label for="email"> Email : </label>' . 
            '<input type="text" id="email" name="email" class="widefat" required /></div>' .

            '<div><label for="phone"> Phone : </label>' . 
            '<input type="text" id="phone" name="phone" class="widefat" required /></div>' .

            '<div><label for="domaine"> Domaine : </label>' . 
            '<input type="text" id="domaine" name="domaine" class="widefat" required /></div>' .

            '<div><label for="street"> Street : </label>' . 
            '<input type="text" id="street" name="street" class="widefat" required /></div>' .
            '<div><label for="address"> City : </label>' . 
            '<input type="text" id="city" name="city" class="widefat" required /></div>' .            
            '<div><label for="address"> Zip-Code : </label>' . 
            '<input type="text" id="zip-code" name="zip-code" class="widefat" required /></div>' .

            // '<select id="address" name="address">';

            // foreach($db->findAll('addresses') as $address) {
            //     echo '<option name="address" value="'. $address->street . $address->city .'">' . $address->street . " " . $address->city . '</option> ';
            // }
            // echo '</select>' .
            '<div><label for="domaine"> Participant : </label>' . 
            '<input type="radio" name="participant" class="widefat" value="true" /> Yes' .
            '<input type="radio" name="not-participant" class="widefat" value="true" /> No' .
            '<div> <input type="submit" value="Add"/></div></form>';
        // }
        // ADD CLUBS FORM

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