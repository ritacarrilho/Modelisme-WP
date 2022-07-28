<?php
/**
 * Plugin Name: Modelisme Plugin 
 * Description: Occitanie Modelisme Plugin
 * Author: Rita 
 * Version: 1.0.0
 */

require_once plugin_dir_path(__FILE__) . 'modelisme/service/Modelisme_Database_service.php';
require_once plugin_dir_path(__FILE__) . 'modelisme/Club_List.php';
require_once plugin_dir_path(__FILE__) . 'modelisme/Members_List.php';
require_once plugin_dir_path(__FILE__) . 'modelisme/Competitions_List.php';
require_once plugin_dir_path(__FILE__) . 'modelisme/Categories_List.php';


class Modelisme 
{
    public function __construct() {
        // plugin activation: tables creation
        register_activation_hook(__FILE__, array('Modelisme_Database_service', 'create_db'));  //catches the plugin activation (class name, method of table creation)

		// register_deactivation_hook(__FILE__, array('Modelisme_Database_service', 'empty_db'));

		// register_uninstall_hook(__File__, array('Modelisme_Database_service', 'drop_db'));

        add_action('admin_menu', [$this, 'add_menu_modelisme']); // add the client menu to the wp interface
    }

    public function add_menu_modelisme() {
        add_menu_page(
            "Modelisme Occitanie", 
            "Modelisme", 
            "manage_options", 
            "occitanieModelisme", 
            array($this, 'modelisme_home'), 
            "dashicons-car", 
            40
        );
// add submenus to the client menu
       add_submenu_page(
           'occitanieModelisme',
           'All Modelisme Clubs', 
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
            'Modelisme Categories', 
            'Categories', 
            'manage_options', 
            'allCategories', 
            [$this, 'modelisme_categories']
         ); 

         add_submenu_page(
            'occitanieModelisme',
            'Modelisme Competitions', 
            'Competitions', 
            'manage_options', 
            'allCompetitions', 
            [$this, 'modelisme_competition']
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

// MODELISME 
    public function modelisme_home() { ?>
        <div class="wrap">
            <h1><?php echo get_admin_page_title()?></h1>

            <h3>Welcome to the Modelisme Back Office.</h3>
            <p>Here you can find all info about Occitanie's Interdepartemental Modelisme.</p>

            <table class="wp-list-table widefat fixed striped table-view-list pages">
                <thead>
                    <tr>
                        <th scope="col" id="label" class="manage-column column-id column-primary sortable asc">
                            <a href="http://occitanie-wp.lndo.site/wp-admin/admin.php?page=occitanieModelisme&amp;orderby=label&amp;order=desc">
                                <span>Menu Label</span>
                                <span class="sorting-indicator"></span>
                            </a>
                        </th>

                        <th scope="col" id="description" class="manage-column column-name sortable asc">
                            <a href="http://occitanie-wp.lndo.site/wp-admin/admin.php?page=occitanieModelisme&amp;orderby=description&amp;order=desc">
                                <span>Description</span>
                                <span class="sorting-indicator"></span>
                            </a>
                        </th>	
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="id column-id has-row-actions column-primary" data-colname="label">Clubs</td>
                        <td class="name column-name" data-colname="Category Name">Add, change and delete clubs</td>
                    </tr>
                        
                    <tr>
                        <td class="id column-id has-row-actions column-primary" data-colname="label">Members</td>
                        <td class="name column-name" data-colname="Category Name">Add, change and delete members of each club</td>
                    </tr>

                    <tr>
                        <td class="id column-id has-row-actions column-primary" data-colname="label">Categories</td>
                        <td class="name column-name" data-colname="Category Name">Add, change and delete categories</td>
                    </tr>

                    <tr>
                        <td class="id column-id has-row-actions column-primary" data-colname="label">Competitions</td>
                        <td class="name column-name" data-colname="Category Name">Add, change and delete competitions</td>
                    </tr>

                    <tr>
                        <td class="id column-id has-row-actions column-primary" data-colname="label">Scores</td>
                        <td class="name column-name" data-colname="Category Name">Add, change and delete scores</td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php
    }

// CATEGORIES
    public function modelisme_categories() { ?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title() ?></h2>

        <?php
        $db = new Modelisme_Database_service;

        if(isset($_POST['send']) && $_POST['send'] == 'ok') { 
            $db->save_category();
            // echo '<pre>'; var_dump($_POST);
        }

        if(isset($_POST['action']) && $_POST['action'] == 'del') {
            $db->delete_row('categories', $_POST['id']);
        }

        // SHOW CATEGORIES INFO TABLE
        if($_REQUEST['page'] == 'allCategories' && $_POST['action'] == "") {
            $table = new Categories_List;
                $table->prepare_items();
                echo $table->display(); 
        ?>
        
            <form method="post">
                <input type="submit" value="Add Category" id="doaction" class="button action" name="action"/>
                <input type="submit" value="View Details" id="doaction" class="button action" name="action"/>
            </form> 
        </div>
        <?php }
                elseif ($_REQUEST['page'] == 'allCategories' && $_POST['action'] == 'View Details' || $_POST['action'] == 'del') { ?>
                    <table class="table-striped" style="padding-top: 20px;">
                        <thead>
                            <tr>
                                <th scope="col"><strong>ID</strong><th>
                                <th scope="col"><strong>Category Name</strong><th>
                            </tr>
                            </thead>
                            
                            <?php 

                            foreach($db->findAll('categories') as $categories) { // show all categories list with delete button
                            ?>
                            <tr>
                                <td><?= $categories->id ?> <td>
                                <td><?= $categories->name ?> <td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="action" value="del" /> 
                                        <input type="hidden" name="id" value=" <?= $categories->id ?>" />
                                        <input type="submit" id="doaction" class="button action" value="del"/>
                                    </form>
                                </td>
                            </tr> 
                        <?php } ?>
                            </table>
            
                            <form method="post" style="padding-top: 20px;">
                                <input type="submit" value="Go Back" id="doaction" class="button action" name="" />
                            </form>    
                    <?php } 
            //  SHOW FORMULARY TO ADD A NEW CATEGORY
            elseif($_REQUEST['page'] == 'allCategories' && $_POST['action'] == 'Add Category')  { ?>
                <h3>Add new Category</h3> 

                <form method="post">
                    <input type="hidden" name="send" value="ok"/>
                    <div>
                        <label for="name"> Category Name : </label>
                        <input type="text" id="name" name="name" class="widefat" required />
                    </div>
                    <div class="tablenav bottom"> 
                        <input type="submit" id="doaction" class="button action" value="Add Category"/>
                    </div>
                </form>
            

            <form method="post" class="tablenav bottom">
                <input type="submit" value="Go Back" id="doaction" class="button action" name="" />
            </form> 
    <?php
            }  
    }

// COMPETITIONS 
    public function modelisme_competition() { ?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title() ?></h2>
        <?php
        $db = new Modelisme_Database_service;

        if(isset($_POST['send']) && $_POST['send'] == 'ok') { 
            $db->save_competition();
            // echo '<pre>'; var_dump($_POST);
        }

        if(isset($_POST['action']) && $_POST['action'] == 'del') { 
            $db->delete_row('competitions', $_POST['id']);
        }

        // SHOW COMPETITIONS INFO TABLE
        if($_REQUEST['page'] == 'allCompetitions' && $_POST['action'] == "") {
            $table = new Competitions_List;
                $table->prepare_items();
                echo $table->display(); 
        ?>
            <form method="post">
                <input type="submit" value="View Details" id="doaction" class="button action" name="action" />
                <input type="submit" value="Add Competition" id="doaction" class="button action" name="action"/>
            </form> 
        </div>
        <?php }
        elseif ($_REQUEST['page'] == 'allCompetitions' && $_POST['action'] == 'View Details' || $_POST['action'] == 'del') { ?>
            <table class="table-striped" style="padding-top: 15px;">
                <thead>
                    <tr>
                        <th scope="col"><strong>ID</strong><th>
                        <th scope="col"><strong>Competition Name</strong><th>
                        <th scope="col"><strong>Total Courses</strong><th>
                        <th scope="col"><strong>Category Name</strong><th>
                    </tr>
                    </thead>
                    
                    <?php 
                    // echo '<pre>'; var_dump($_POST); echo '</pre>';
                    foreach($db->findCompetitions() as $competition) { // show all competitions list with delete button
                    ?>
                    <tr>
                        <td><?= $competition->id ?> <td>
                        <td><?= $competition->name ?> <td>
                        <td><?= $competition->total_courses ?> <td>
                        <td><?= $competition->category_name ?> <td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="action" value="del" /> 
                                <input type="hidden" name="id" value=" <?= $competition->id ?>" />
                                <input type="submit" id="doaction" class="button action" value="del"/>
                            </form></td>
                        </tr> 
                <?php } ?>
                    </table>
    
                    <form method="post" class="tablenav bottom">
                        <input type="submit" value="Go Back" id="doaction" class="button action" name="" />
                    </form>    
            <?php } 
        //  SHOW FORMULARY TO ADD A NEW COMPETITION 
        elseif($_REQUEST['page'] == 'allCompetitions' && $_POST['action'] == 'Add Competition')  { ?>
            <h3>Add new Competition</h3> 
    
            <form method="post">
                <input type="hidden" name="send" value="ok"/>
                <div style="padding-bottom: 10px;">
                    <label for="competition_name"> Competition Name : </label>
                    <input type="text" id="competition_name" name="competition_name" class="widefat" required />
                </div>
                <div style="padding-bottom: 10px;">
                    <label for="total_courses"> Total Courses : </label>
                    <input type="text" id="total_courses" name="total_courses" class="widefat" required />
                </div>
                <div>
                    <label for="category_id"> Category Name : </label>
                    <select id="category_id" name="category_id">
            <?php foreach($db->findAll('categories') as $category) { ?>
                        <option name="category_id" value="<?= $category->id ?>"> <?=$category->name ?> </option>
            <?php } ?>
                    </select>
                </div>
                <div class="tablenav bottom">
                    <input type="submit" id="doaction" class="button action" value="Add"/>
                </div>
            </form>

            <form method="post">
                <div class="tablenav bottom">
                    <input type="submit" value="Go Back" id="doaction" class="button action" name="" />
                </div>
            </form> 
        <?php
        } 
    }

// CLUBS 
    public function modelisme_clubs() { ?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title() ?></h2>

        <?php
        $db = new Modelisme_Database_service;

        if(isset($_POST['send']) && $_POST['send'] == 'ok') { 
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
                        <input type="submit" value="View Details" id="doaction" class="button action" name="action" />
                        <input type="submit" value="Add Club" id="doaction" class="button action" name="action"/>
                    </form> 
            </div>
        <?php }
        elseif ($_REQUEST['page'] == 'allClubs' && $_POST['action'] == 'View Details' || $_POST['action'] == 'del') {?>
            <table class="table-striped" style="padding-top: 15px;">
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
                foreach($db->findAll('clubs') as $club) {
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
                                <input type="submit" id="doaction" class="button action" value="del"/>
                            </form>
                        </td>
                    </tr> 
            <?php } ?>
                </table>

                <form method="post" class="tablenav bottom">
                    <input type="submit" value="Go Back" id="doaction" class="button action" name="" />
                </form>    
        <?php } 
        //  SHOW FORMULARY TO ADD A NEW CLUB 
        elseif($_REQUEST['page'] == 'allClubs' && $_POST['action'] == 'Add Club')  { ?>
            <h3>Add new Club</h3> 

            <form method="post">
                <input type="hidden" name="send" value="ok"/>
                <div>
                    <label for="name"> Name : </label>
                    <input type="text" id="name" name="name" class="widefat" required />
                </div>
                <div>
                    <label for="email"> Email : </label>
                    <input type="text" id="email" name="email" class="widefat" required />
                </div>
                <div>
                    <label for="phone"> Phone : </label>
                    <input type="text" id="phone" name="phone" class="widefat" required />
                </div>
                <div>
                    <label for="street"> Street : </label>
                    <input type="text" id="street" name="street" class="widefat" required />
                </div>
                <div>
                    <label for="address"> City : </label>
                <input type="text" id="city" name="city" class="widefat" required />
                </div>            
                <div>
                    <label for="address"> Zip-Code : </label>
                <input type="text" id="zip-code" name="zip_code" class="widefat" required />
                </div>

                <select id="domain" name="domain" style="margin-bottom: 10px; margin-top: 10px">
                <option name="domain" selected="true" disabled="disabled">Choose a Category</option>
            <?php
                foreach($db->findAll('categories') as $category) { 
                    // var_dump($category->name);
            ?>
                    <option name="domain" value="<?= $category->id ?>"> <?=$category->name ?> </option>
            <?php 
            } 
            ?>
                </select>
                <div>
                    <label for="domaine"> Participant : </label>
                    <input type="radio" name="participant" class="widefat" value="1" /> Yes
                    <input type="radio" name="participant" class="widefat" value="0" /> No
                </div>
                <div class="tablenav bottom">
                    <input type="submit" id="doaction" class="button action" value="Add"/>
                </div>
            </form>

            <form method="post">
                <input type="submit" value="Go Back" id="doaction" class="button action"/>
            </form> 
    <?php }        
    }

// MEMBERS
    public function modelisme_members() { ?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title() ?></h2>

        <?php
        $db = new Modelisme_Database_service; 

        if(isset($_POST['send']) && $_POST['send'] == 'ok') { 
            $db->save_member();
            // echo '<pre>'; var_dump($_POST);
        }

        if(isset($_POST['action']) && $_POST['action'] == 'del') { // delete member from database
            $db->delete_row('adherents', $_POST['id']);
        }

        // SHOW MEMBERS INFO TABLE
        if($_REQUEST['page'] == 'allMembers' && $_POST['action'] == "") {
            $table = new Members_List;
                $table->prepare_items();
                echo $table->display(); 
        ?>
            <form method="post">
                <input type="submit" value="View Details" id="doaction" class="button action" name="action" />
                <input type="submit" value="Add Member" id="doaction" class="button action" name="action"/>
            </form> 
        </div>

            <!--  SHOW ALL MEMBERS TABLE AND COMPLETE INFO -->
            <?php }
            elseif ($_REQUEST['page'] == 'allMembers' && $_POST['action'] == 'View Details' || $_POST['action'] == 'del') {
            ?>
                <table class="table-striped" style="padding-top: 15px;">
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
                
                
            <?php foreach($db->findMembers() as $member) {
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
                                <input type="submit" id="doaction" class="button action" value="del"/>
                            </form>
                        </td>
                    </tr> 
            <?php } ?>
                </table>

                <form method="post" class="tablenav bottom">
                    <input type="submit" value="Go Back" id="doaction" class="button action" name="" />
                </form>    
        <?php } 
        //  SHOW FORMULARY TO ADD A NEW MEMBER 
            elseif($_REQUEST['page'] == 'allMembers' && $_POST['action'] == 'Add Member')  { ?>
                <h3>Add new Club</h3> 

                <form method="post">
                    <input type="hidden" name="send" value="ok"/>
                    <div>
                        <label for="last_name"> Last Name : </label>
                        <input type="text" id="name" name="last_name" class="widefat" required />
                    </div>
                    <div>
                        <label for="first_name"> First Name : </label>
                        <input type="text" id="name" name="first_name" class="widefat" required />
                    </div>
                    <div>
                        <label for="email"> Email : </label>
                        <input type="text" id="email" name="email" class="widefat" required />
                    </div>
                    <div>
                        <label for="phone"> Phone : </label>
                        <input type="text" id="phone" name="phone" class="widefat" required />
                    </div>
                    <div>
                        <label for="club_number"> Club Number : </label>
                        <input type="text" id="phone" name="club_number" class="widefat" required />
                    </div>
                    <div>
                        <label for="street"> Street : </label>
                        <input type="text" id="street" name="street" class="widefat" required />
                    </div>
                    <div>
                        <label for="address"> City : </label>
                        <input type="text" id="city" name="city" class="widefat" required />
                    </div>            
                    <div>
                        <label for="address"> Zip-Code : </label>
                        <input type="text" id="zip-code" name="zip_code" class="widefat" required />
                    </div>

                    <div style="padding-top: 10px;">
                        <select id="club" name="name" style="margin-bottom: 10px; margin-top: 10px">
                            <option name="domain" selected="true" disabled="disabled">Choose a Club
                    <?php
                        foreach($db->findAll('clubs') as $club) { ?>
                            <option name="domain" value="<?= $club->id ?>"> <?=$club->name ?> </option>
                    <?php } ?>
                        </select>
                    <div>
                        <input type="submit" id="doaction" class="button action" value="Add"/>
                    </div>
                </form>

                <form method="post" class="tablenav bottom">
                        <input type="submit" value="Go Back" id="doaction" class="button action" name="" />
                </form> 
            <?php        
        }
    }    

    public function modelisme_scores() { ?>
        <div class="wrap">
            <h2><?php echo get_admin_page_title() ?></h2>

            <p>In development...</p>
        </div>

        <?php
        
    }
}

new Modelisme ();
?>