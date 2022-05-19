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
require_once plugin_dir_path(__FILE__) . 'modelisme/Members_List.php';



class Modelisme 
{
    public function __construct() {
        // plugin activation: tables creation
        register_activation_hook(__FILE__, array('Modelisme_Database_service', 'create_db'));  //catches the plugin activation (class name, method of table creation)

		register_deactivation_hook(__FILE__, array('Ern_Database_service', 'empty_db'));

		register_uninstall_hook(__File__, array('Ern_Database_service', 'drop_db'));

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
           'allClubs', 
           [$this, 'modelisme_clubs']
        ); 

        add_submenu_page(
            'occitanieModelisme',
            'The Club\'s Members', 
            'Members', 
            'manage_options', 
            'allMembers', 
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
// COMPETITIONS 
    public function modelisme_competition() {
        echo "<h2>" . get_admin_page_title() . "</h2>";

        $db = new Modelisme_Database_service; // call the DB
        
    }

// CLUBS 
    public function modelisme_clubs() {
        echo "<h2>" . get_admin_page_title() . "</h2>";

        $db = new Modelisme_Database_service; // appel du service de base

        if(isset($_POST['send']) && $_POST['send'] == 'ok') { // guardar dados do form na tabela, isset evita ter uma warning
            $db->save_club();
            // echo '<pre>'; var_dump($_POST);
        }

        if(isset($_POST['action']) && $_POST['action'] == 'del') { // delete club from database
            $db->delete_row('clubs', $_POST['id']);
        }

        // SHOW CLUBS INFO TABLE
        if($_REQUEST['page'] == 'allClubs' && $_POST['action'] == "") {
            $table = new Club_List;
                $table->prepare_items();
                echo $table->display(); 
        ?>
                <form method="post">
                        <input type="submit" value="View Details" class="btn btn-outline-secondary" name="action" />
                        <input type="submit" value="Add Club" class="btn btn-outline-secondary" name="action"/>
                    </form> 

            <!--  SHOW ALL CLUBS TABLE AND COMPLETE INFO -->
            <?php }
            elseif ($_REQUEST['page'] == 'allClubs' && $_POST['action'] == 'View Details' || $_POST['action'] == 'del') {
            ?>
                <!--  Table header -->
                <table class="table-striped ">
                <thead>
            <tr>
                <th scope="col"><strong>ID</strong><th>
                <th scope="col"><strong>Name</strong><th>
                <th scope="col"><strong>Email</strong><th>
                <th scope="col"><strong>Phone</strong><th>
                <th scope="col"><strong>Domaine</strong><th>
                <th scope="col"><strong>Address</strong><th>
                <th scope="col"><strong>Participant</strong><th>
                </tr>
                </thead>
                
                <?php 
                // echo '<pre>'; var_dump($_POST); echo '</pre>';
                foreach($db->findAll('clubs') as $club) { // afficher lista de todos os clients presentes na tabela com botao de delete
                ?>
                <tr>
                    <td><?= $club->id ?> <td>
                    <td><?= $club->name ?> <td>
                    <td><?= $club->email ?> <td>
                    <td><?= $club->phone ?> <td>
                <?php 
                    // echo '<pre>';var_dump($db->findClubDomain());
                    for ($i=0; $i < count($db->findClubDomain()); $i++) { 
                        if($db->findClubDomain()[$i]->id == $club->id){ ?>
                            <td><?= $db->findClubDomain()[$i]->cat_domain ?><td>
                        <?php }
                    }?>
                    <td><?= $db->findAddressPerClub($club->id)->street ?>, <?= $db->findAddressPerClub($club->id)->city ?>, <?=$db->findAddressPerClub($club->id)->zip_code ?><td>
                    <td><?=(($club->participant == 0) ? "Club in not participant" : "Club is participant") ?><td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="action" value="del" /> 
                            <input type="hidden" name="id" value=" <?= $club->id ?>" />
                            <input type="submit" value="del"/>
                        </form></td>
                    </tr> 
            <?php } ?>
                </table>

                <form method="post">
                        <input type="submit" value="Go Back" class="btn btn-outline-secondary" name="" />
                    </form>    
        <?php } 
        //  SHOW FORMULARY TO ADD A NEW CLUB 
            elseif($_REQUEST['page'] == 'allClubs' && $_POST['action'] == 'Add Club')  { ?>
                <h3>Add new Club</h3> 

                <form method="post">
                <input type="hidden" name="send" value="ok"/>
                <div><label for="name"> Name : </label>
                <input type="text" id="name" name="name" class="widefat" required /></div>

                <div><label for="email"> Email : </label>
                <input type="text" id="email" name="email" class="widefat" required /></div>

                <div><label for="phone"> Phone : </label>
                <input type="text" id="phone" name="phone" class="widefat" required /></div>

                <div><label for="street"> Street : </label>
                <input type="text" id="street" name="street" class="widefat" required /></div>
                <div><label for="address"> City : </label>
                <input type="text" id="city" name="city" class="widefat" required /></div>            
                <div><label for="address"> Zip-Code : </label>
                <input type="text" id="zip-code" name="zip_code" class="widefat" required /></div>

                <select id="domain" name="domain">
            <?php
                foreach($db->findAll('categories') as $category) { 
                    // var_dump($category->name);
            ?>
                    <option name="domain" value="<?= $category->id ?>"> <?=$category->name ?> </option>
            <?php 
            } 
            ?>
                </select>
                <div><label for="domaine"> Participant : </label>
                <input type="radio" name="participant" class="widefat" value="1" /> Yes
                <input type="radio" name="participant" class="widefat" value="0" /> No
                <div> <input type="submit" value="Add"/></div></form>

                <form method="post">
                        <input type="submit" value="Go Back" class="btn btn-outline-secondary" name="" />
                    </form> 
            <?php        
            }  
    }

    // MEMBERS
    public function modelisme_members() {
        echo "<h2>" . get_admin_page_title() . "</h2>";


        $db = new Modelisme_Database_service; // appel du service de base

        if(isset($_POST['send']) && $_POST['send'] == 'ok') { // guardar dados do form na tabela, isset evita ter uma warning
            $db->save_member();
            // echo '<pre>'; var_dump($_POST);
        }

        if(isset($_POST['action']) && $_POST['action'] == 'del') { // delete club from database
            $db->delete_row('adherents', $_POST['id']);
        }

        // SHOW CLUBS INFO TABLE
        if($_REQUEST['page'] == 'allMembers' && $_POST['action'] == "") {
            $table = new Members_List;
                $table->prepare_items();
                echo $table->display(); 
        ?>
                <form method="post">
                        <input type="submit" value="View Details" class="btn btn-outline-secondary" name="action" />
                        <input type="submit" value="Add Member" class="btn btn-outline-secondary" name="action"/>
                    </form> 

            <!--  SHOW ALL CLUBS TABLE AND COMPLETE INFO -->
            <?php }
            elseif ($_REQUEST['page'] == 'allMembers' && $_POST['action'] == 'View Details' || $_POST['action'] == 'del') {
            ?>
                <!--  Table header -->
                <table class="table-striped ">
                <thead>
            <tr>
                <th scope="col"><strong>ID</strong><th>
                <th scope="col"><strong>Last Name</strong><th>
                <th scope="col"><strong>First Name</strong><th>
                <th scope="col"><strong>Email</strong><th>
                <th scope="col"><strong>Phone</strong><th>
                <th scope="col"><strong>Club Number</strong><th>
                <th scope="col"><strong>Address</strong><th>
                <th scope="col"><strong>Club Name</strong><th>
                </tr>
                </thead>
                
                <?php 
                // echo '<pre>'; var_dump($_POST); echo '</pre>';
                foreach($db->findMembers() as $member) { // afficher lista de todos os clients presentes na tabela com botao de delete
                ?>
                <tr>
                    <td><?= $member->id ?> <td>
                    <td><?= $member->last_name ?> <td>
                    <td><?= $member->first_name ?> <td>
                    <td><?= $member->email ?> <td>
                    <td><?= $member->phone ?> <td>
                    <td><?= $member->club_number ?> <td>
                    <td><?= $member->street ?>, <?= $member->city ?>, <?=$member->zip_code ?><td>
                    <td><?= $member->name ?><td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="action" value="del" /> 
                            <input type="hidden" name="id" value=" <?= $member->id ?>" />
                            <input type="submit" value="del"/>
                        </form></td>
                    </tr> 
            <?php } ?>
                </table>

                <form method="post">
                        <input type="submit" value="Go Back" class="btn btn-outline-secondary" name="" />
                    </form>    
        <?php } 
        //  SHOW FORMULARY TO ADD A NEW CLUB 
            elseif($_REQUEST['page'] == 'allMembers' && $_POST['action'] == 'Add Member')  { ?>
                <h3>Add new Club</h3> 

                <form method="post">
                <input type="hidden" name="send" value="ok"/>
                <div><label for="last_name"> Last Name : </label>
                <input type="text" id="name" name="last_name" class="widefat" required /></div>

                <div><label for="first_name"> First Name : </label>
                <input type="text" id="name" name="first_name" class="widefat" required /></div>

                <div><label for="email"> Email : </label>
                <input type="text" id="email" name="email" class="widefat" required /></div>

                <div><label for="phone"> Phone : </label>
                <input type="text" id="phone" name="phone" class="widefat" required /></div>

                <div><label for="club_number"> Club Number : </label>
                <input type="text" id="phone" name="club_number" class="widefat" required /></div>

                <div><label for="street"> Street : </label>
                <input type="text" id="street" name="street" class="widefat" required /></div>
                <div><label for="address"> City : </label>
                <input type="text" id="city" name="city" class="widefat" required /></div>            
                <div><label for="address"> Zip-Code : </label>
                <input type="text" id="zip-code" name="zip_code" class="widefat" required /></div>


                <div><label for="club_number"> Club Name : </label>
                <select id="club" name="name">
            <?php
                foreach($db->findAll('clubs') as $club) { 
                    // var_dump($category->name);
            ?>
                    <option name="domain" value="<?= $club->id ?>"> <?=$club->name ?> </option>
            <?php 
            } 
            ?>
                
                <div> <input type="submit" value="Add"/></div></form>

                <form method="post">
                        <input type="submit" value="Go Back" class="btn btn-outline-secondary" name="" />
                    </form> 
            <?php        
        }
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